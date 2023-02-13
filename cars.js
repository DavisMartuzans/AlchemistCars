const cars = [
  {make: "Toyota", model: "Camry", year: 2020},
  {make: "Toyota", model: "Corolla", year: 2021},
  {make: "Honda", model: "Civic", year: 2022},
  {make: "Honda", model: "Accord", year: 2023},
  {make: "Tesla", model: "Model 3", year: 2024},
];

const form = document.querySelector("form");
const selectMake = document.querySelector("#make");
const selectModel = document.querySelector("#model");
const resultContainer = document.querySelector("#result");

form.addEventListener("submit", (e) => {
  e.preventDefault();

  const selectedMake = selectMake.value;
  const selectedModel = selectModel.value;

  resultContainer.innerHTML = "";

  for (const car of cars) {
    if (car.make === selectedMake && car.model === selectedModel) {
      const carEl = document.createElement("div");
      carEl.innerHTML = `${car.make} ${car.model} (${car.year})`;
      resultContainer.appendChild(carEl);
    }
  }
});

  