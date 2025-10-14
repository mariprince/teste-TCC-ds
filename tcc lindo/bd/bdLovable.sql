-- Criar enum para tipos de usuário
CREATE TYPE public.user_type AS ENUM ('motorista', 'empresa');

-- Criar enum para tipos de veículo
CREATE TYPE public.vehicle_type AS ENUM ('caminhao_toco', 'caminhao_truck', 'carreta', 'bi_trem', 'rodotrem', 'caminhao_prancha');

-- Criar enum para status do frete
CREATE TYPE public.freight_status AS ENUM ('disponivel', 'aceito', 'em_andamento', 'concluido', 'cancelado');

-- Tabela de perfis de usuário (conecta com auth.users)
CREATE TABLE public.profiles (
  id UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE PRIMARY KEY,
  user_type user_type NOT NULL,
  created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now(),
  updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now()
);

-- Tabela de motoristas
CREATE TABLE public.motoristas (
  id UUID NOT NULL DEFAULT gen_random_uuid() PRIMARY KEY,
  user_id UUID NOT NULL REFERENCES public.profiles(id) ON DELETE CASCADE,
  nome TEXT NOT NULL,
  cpf_cnpj TEXT NOT NULL UNIQUE,
  cnh TEXT NOT NULL,
  curriculo TEXT,
  tipo_caminhao vehicle_type NOT NULL,
  documento_veiculo TEXT NOT NULL,
  created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now(),
  updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now()
);

-- Tabela de empresas
CREATE TABLE public.empresas (
  id UUID NOT NULL DEFAULT gen_random_uuid() PRIMARY KEY,
  user_id UUID NOT NULL REFERENCES public.profiles(id) ON DELETE CASCADE,
  nome_fantasia TEXT NOT NULL,
  email TEXT NOT NULL UNIQUE,
  cnpj TEXT NOT NULL UNIQUE,
  endereco TEXT NOT NULL,
  created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now(),
  updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now()
);

-- Tabela de fretes
CREATE TABLE public.fretes (
  id UUID NOT NULL DEFAULT gen_random_uuid() PRIMARY KEY,
  empresa_id UUID NOT NULL REFERENCES public.empresas(id) ON DELETE CASCADE,
  motorista_id UUID REFERENCES public.motoristas(id) ON DELETE SET NULL,
  data_hora_saida TIMESTAMP WITH TIME ZONE NOT NULL,
  estimativa_entrega TIMESTAMP WITH TIME ZONE NOT NULL,
  ponto_partida TEXT NOT NULL,
  destino_final TEXT NOT NULL,
  tipo_carga TEXT NOT NULL,
  veiculo_adequado vehicle_type NOT NULL,
  salario DECIMAL(10,2) NOT NULL,
  descricao TEXT,
  status freight_status NOT NULL DEFAULT 'disponivel',
  created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now(),
  updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now()
);

-- Habilitar RLS em todas as tabelas
ALTER TABLE public.profiles ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.motoristas ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.empresas ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.fretes ENABLE ROW LEVEL SECURITY;

-- Policies para profiles
CREATE POLICY "Users can view their own profile" ON public.profiles
  FOR SELECT USING (auth.uid() = id);

CREATE POLICY "Users can update their own profile" ON public.profiles
  FOR UPDATE USING (auth.uid() = id);

CREATE POLICY "Users can insert their own profile" ON public.profiles
  FOR INSERT WITH CHECK (auth.uid() = id);

-- Policies para motoristas
CREATE POLICY "Motoristas can view their own data" ON public.motoristas
  FOR SELECT USING (
    EXISTS (
      SELECT 1 FROM public.profiles 
      WHERE profiles.id = auth.uid() 
      AND profiles.id = motoristas.user_id
    )
  );

CREATE POLICY "Motoristas can update their own data" ON public.motoristas
  FOR UPDATE USING (
    EXISTS (
      SELECT 1 FROM public.profiles 
      WHERE profiles.id = auth.uid() 
      AND profiles.id = motoristas.user_id
    )
  );

CREATE POLICY "Motoristas can insert their own data" ON public.motoristas
  FOR INSERT WITH CHECK (
    EXISTS (
      SELECT 1 FROM public.profiles 
      WHERE profiles.id = auth.uid() 
      AND profiles.id = motoristas.user_id
      AND profiles.user_type = 'motorista'
    )
  );

CREATE POLICY "Empresas can view motoristas for fretes" ON public.motoristas
  FOR SELECT USING (
    EXISTS (
      SELECT 1 FROM public.profiles 
      WHERE profiles.id = auth.uid() 
      AND profiles.user_type = 'empresa'
    )
  );

-- Policies para empresas
CREATE POLICY "Empresas can view their own data" ON public.empresas
  FOR SELECT USING (
    EXISTS (
      SELECT 1 FROM public.profiles 
      WHERE profiles.id = auth.uid() 
      AND profiles.id = empresas.user_id
    )
  );

CREATE POLICY "Empresas can update their own data" ON public.empresas
  FOR UPDATE USING (
    EXISTS (
      SELECT 1 FROM public.profiles 
      WHERE profiles.id = auth.uid() 
      AND profiles.id = empresas.user_id
    )
  );

CREATE POLICY "Empresas can insert their own data" ON public.empresas
  FOR INSERT WITH CHECK (
    EXISTS (
      SELECT 1 FROM public.profiles 
      WHERE profiles.id = auth.uid() 
      AND profiles.id = empresas.user_id
      AND profiles.user_type = 'empresa'
    )
  );

-- Policies para fretes
CREATE POLICY "Empresas can manage their own fretes" ON public.fretes
  FOR ALL USING (
    EXISTS (
      SELECT 1 FROM public.empresas 
      WHERE empresas.id = fretes.empresa_id 
      AND empresas.user_id = auth.uid()
    )
  );

CREATE POLICY "Motoristas can view available fretes" ON public.fretes
  FOR SELECT USING (
    EXISTS (
      SELECT 1 FROM public.profiles 
      WHERE profiles.id = auth.uid() 
      AND profiles.user_type = 'motorista'
    )
  );

CREATE POLICY "Motoristas can update fretes they accepted" ON public.fretes
  FOR UPDATE USING (
    EXISTS (
      SELECT 1 FROM public.motoristas 
      WHERE motoristas.id = fretes.motorista_id 
      AND motoristas.user_id = auth.uid()
    )
  );

-- Função para atualizar updated_at
CREATE OR REPLACE FUNCTION public.update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
  NEW.updated_at = now();
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Triggers para atualizar updated_at automaticamente
CREATE TRIGGER update_profiles_updated_at
  BEFORE UPDATE ON public.profiles
  FOR EACH ROW EXECUTE FUNCTION public.update_updated_at_column();

CREATE TRIGGER update_motoristas_updated_at
  BEFORE UPDATE ON public.motoristas
  FOR EACH ROW EXECUTE FUNCTION public.update_updated_at_column();

CREATE TRIGGER update_empresas_updated_at
  BEFORE UPDATE ON public.empresas
  FOR EACH ROW EXECUTE FUNCTION public.update_updated_at_column();

CREATE TRIGGER update_fretes_updated_at
  BEFORE UPDATE ON public.fretes
  FOR EACH ROW EXECUTE FUNCTION public.update_updated_at_column();

-- Trigger para criar perfil automaticamente ao criar usuário
CREATE OR REPLACE FUNCTION public.handle_new_user()
RETURNS TRIGGER AS $$
BEGIN
  INSERT INTO public.profiles (id, user_type)
  VALUES (NEW.id, COALESCE(NEW.raw_user_meta_data->>'user_type', 'motorista')::user_type);
  RETURN NEW;
END;
$$ LANGUAGE plpgsql SECURITY DEFINER;

CREATE TRIGGER on_auth_user_created
  AFTER INSERT ON auth.users
  FOR EACH ROW EXECUTE FUNCTION public.handle_new_user();