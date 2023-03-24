const cars = [
  { make: 'BMW', model: '330i', year: 2002 },
  { make: 'Mercedes-Benz', model: 'E200', year: 2002 },
  { make: 'Audi', model: 'A6', year: 1994 },
];

// Function to display all cars
function displayAllCars() {
  const carList = document.querySelector('.car-list');
  carList.innerHTML = '';
  
  cars.forEach(car => {
    const carElement = document.createElement('div');
    carElement.classList.add('car');
    carElement.innerHTML = `
      <h2>${car.make} ${car.model}</h2>
      <p>Year: ${car.year}</p>
    `;
    carList.appendChild(carElement);
  });
}

// Function to filter cars
function filterCars() {
  const make = document.querySelector('#make').value;
  const model = document.querySelector('#model').value;
  const year = document.querySelector('#year').value;
  
  const filteredCars = cars.filter(car => {
    if (make && car.make !== make) {
      return false;
    }
    if (model && car.model !== model) {
      return false;
    }
    if (year && car.year !== parseInt(year)) {
      return false;
    }
    return true;
  });
  
  const carList = document.querySelector('.car-list');
  carList.innerHTML = '';
  
  filteredCars.forEach(car => {
    const carElement = document.createElement('div');
    carElement.classList.add('car');
    carElement.innerHTML = `
      <h2>${car.make} ${car.model}</h2>
      <p>Year: ${car.year}</p>
    `;
    carList.appendChild(carElement);
  });
}

// Add event listener to filter button
const filterButton = document.querySelector('#filter-button');
filterButton.addEventListener('click', filterCars);

// Display all cars on page load
displayAllCars();