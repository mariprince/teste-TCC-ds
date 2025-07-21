
document.querySelector('.custom-btn').addEventListener('click', function() {    event.preventDefault();

    const nomeM = document.getElementById('nome_motorista').value;
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
    console.log(`Motorista cadastrado: ${nomeM}, ${cpf}, ${curriculo}`);
    document.getElementById('form_motorista').reset();
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