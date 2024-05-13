import "./bootstrap.js";

document.getElementById('toggleButton').addEventListener('click', function() {
    this.style.display = 'none';
    document.getElementById('descriptionText').classList.remove('d-none');
});


import "./styles/app.css";

console.log("This log comes from assets/app.js - welcome to AssetMapper! 🎉");
