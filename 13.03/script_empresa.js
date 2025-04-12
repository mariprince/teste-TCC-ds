document.querySelector('.custom-btn').addEventListener('click', function() {    event.preventDefault();
    const nomeE = document.getElementById('nome_empresa').value;
    const cnpj = document.getElementById('cnpj').value;
    const emailE = document.getElementById('email_empresa').value;
    
    // Aqui você pode adicionar a lógica para enviar os dados para o backend
    console.log(`Empresa cadastrada: ${nomeE}, ${cnpj}, ${emailE}`);
    document.getElementById('form_empresa').reset();
});

const myObserver = new IntersectionObserver( (entries) => {
    entries.forEach( (entry) => {
        if(entry.isIntersecting){
            entry.target.classList.add('show')
        }else{
            entry.target.classList.remove('show')
        }
    })
})

const elements = document.querySelectorAll('.pagcadastro');

elements.forEach( (element) => myObserver.observe(element));