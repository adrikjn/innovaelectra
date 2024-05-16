import "./bootstrap.js";

document.addEventListener('DOMContentLoaded', () => {

    const setupAddToCart = () => {
        const addToCartButton = document.getElementById('addToCartButton');
        const successMessage = document.getElementById('successMessage');

        if (addToCartButton && successMessage) {
            addToCartButton.addEventListener('click', () => {
                const product = {
                    id: addToCartButton.dataset.productId,
                    title: addToCartButton.dataset.productTitle,
                    price: parseFloat(addToCartButton.dataset.productPrice),
                    image: addToCartButton.dataset.productImage,
                    quantity: 1
                };

                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                const productIndex = cart.findIndex(item => item.id === product.id);

                if (productIndex === -1) {
                    cart.push(product);
                } else {
                    cart[productIndex].quantity += 1;
                }

                localStorage.setItem('cart', JSON.stringify(cart));

                // Affichage du message de succès
                successMessage.classList.remove('d-none');

            });
        }
    };

    // Initialize all functions
    setupAddToCart();
});

import "./styles/app.css";

