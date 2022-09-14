const labels = [
    'August',
    'September',
    'October',
    'November',
    'December',
    'January',
];

const data = {
    labels: labels,
    datasets: [{
        label: 'Dataset',
        backgroundColor: 'rgb(65,129,127)',
        borderColor: 'rgb(65,129,127)',
        color: 'white',
        data: [0, 10, 5, 2, 20, 30, 45],
    }]
};

const config = {
    type: 'line',
    data: data,
    options: {}
};


const myChart = new Chart(
    document.getElementById('myChart'),
    config
);