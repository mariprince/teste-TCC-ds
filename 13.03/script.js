document.querySelector('.custom-btn').addEventListener('click', function() {    event.preventDefault();
    const emailM = document.getElementById('email').value;
    const senha = document.getElementById('password')
    const cpf = document.getElementById('cpf').value;
    const curriculo = document.getElementById('formFile').value;
    if (curriculo.length > 0) {
        console.log('Currículos selecionados:');
        for (let i = 0; i < curriculo.length; i++) {
            console.log(curriculo[i].name);
        }
    } else {
        console.log('Nenhum currículo selecionado.');
    }
    // Aqui você pode adicionar a lógica para enviar os dados para o backend
    console.log(`Motorista cadastrado: ${emailM}, ${password}, ${cpf}, ${curriculo}`);
    document.getElementById('formCadastroMotorista').reset();
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

let card = document.querySelector(".cardBI")
let motoristaButton = document.querySelector(".motoristaButton")
let empresaButton = document.querySelector(".empresaButton")

motoristaButton.onclick = () => {
    card.classList.remove("cadastroActive")
    card.classList.add("loginActive")
}

empresaButton.onclick = () => {
    card.classList.remove("loginActive")
    card.classList.add("cadastroActive")
}

