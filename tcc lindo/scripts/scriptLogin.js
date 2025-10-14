
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