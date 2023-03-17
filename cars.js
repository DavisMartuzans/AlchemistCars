const cars = [
  {
    make: "Toyota",
    model: "Corolla",
    year: 2020,
    price: 25000,
    image: "https://via.placeholder.com/300x200",
    features: ["Automatic", "4-door sedan", "Gasoline"]
  },
  {
    make: "Honda",
    model: "Civic",
    year: 2018,
    price: 20000,
    image: "https://via.placeholder.com/300x200",
    features: ["Manual", "2-door coupe", "Gasoline"]
  },
  {
    make: "Tesla",
    model: "Model 3",
    year: 2021,
    price: 45000,
    image: "https://via.placeholder.com/300x200",
    features: ["Electric", "4-door sedan"]
  }
];

const carList = document.getElementById("car-list");

function showCars(cars) {
  carList.innerHTML = "";
  for (let i = 0; i < cars.length; i++) {
    const car = cars[i];
    const carCard = document.createElement("div");
    carCard.classList.add("car-card");
    carCard.innerHTML = `
      <img src="${car.image}" alt="${car.make} ${car.model}">
      <h2>${car.make} ${car.model}</h2>
      <p>Year: ${car.year}</p>
      <p>Price: $${car.price.toLocaleString()}</p>
      <p>Features: ${car.features.join(", ")}</p>
    `;
    carList.appendChild(carCard);
  }
}

showCars(cars);

const filterForm = document.getElementById("filter-form");

filterForm.addEventListener("submit", function(event) {
  event.preventDefault();

  const selectedMake = document.querySelector('input[name="make"]:checked').value;
  const selectedYear = document.querySelector('input[name="year"]:checked').value;
  const selectedPrice = document.querySelector('input[name="price"]:checked').value;

  let filteredCars = cars.filter(function(car) {
    return car.make === selectedMake &&
           car.year === Number(selectedYear) &&
           car.price <= Number(selectedPrice);
  });

  showCars(filteredCars);
});