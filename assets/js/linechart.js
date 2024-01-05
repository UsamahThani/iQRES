const equipData = [
  { month: 'Jan', equipment: { new: 430, broken:230 }},
  { month: 'Feb', equipment: { new: 100, broken:130 }},
  { month: 'Mar', equipment: { new: 500, broken:600 }},
  { month: 'Apr', equipment: { new: 420, broken:140 }},
  { month: 'May', equipment: { new: 120, broken:130 }},
  { month: 'Jun', equipment: { new: 300, broken:200 }},
  
];

// setup 
const data = {
  datasets: [{
    label: 'New',
    data: equipData,
    backgroundColor: 'rgba(81, 231, 93, 0.2)',
    borderColor: 'rgba(81, 231, 93, 1)',
    parsing: {
      yAxisKey: 'equipment.new'
    }
  },
  {
    label: 'Broken',
    data: equipData,
    backgroundColor: 'rgba(255, 26, 104, 0.2)',
    borderColor: 'rgba(255, 26, 104, 1)',
    parsing: {
      yAxisKey: 'equipment.broken'
    }
  }]
};

// config 
const config = {
  type: 'line',
  data,
  options: {
    tension: 0.4,
    parsing: {
      xAxisKey: 'month',
    },
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
};

// render init block
const myChart = new Chart(
  document.getElementById('myChart'),
  config
);

// Instantly assign Chart.js version
const chartVersion = document.getElementById('chartVersion');
chartVersion.innerText = Chart.version;