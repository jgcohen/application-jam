import React, { useContext, useEffect } from 'react';
import { CartContext } from '../context/CartContext';

const CartPage = () => {
  const cartContext = useContext(CartContext);
  if (!cartContext) {
    throw new Error("Expected to be rendered within a CartProvider");
  }
  const { cart, setCart } = cartContext;
  const total = cart.reduce((acc, item) => acc + item.product.price * item.quantity, 0);


  useEffect(() => {
    const savedCart = localStorage.getItem('cart');
    
    if (savedCart) {
        setCart(JSON.parse(savedCart));
        console.log('Restoring cart from localStorage:', JSON.parse(savedCart));
    }
}, []);
const fetchCheckoutSession = async () => {
  fetch('http://localhost:8000/checkout', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({ cart })
  }).then(async response => {
    if (response.ok) {
        const session = await response.json();
        
        window.location.href = session.url;
    } else {
        console.error('Failed to create checkout session:', response.statusText);
    }

  }
  
  )
};
const handleCheckout = async () => {
  await fetchCheckoutSession();
};
return (
  <div className="container">
    <h1 className="text-center my-4">Panier</h1>
    {cart.length > 0 ? (
      <div className="row">
        <div className="col-lg-8">
          {cart.map((item, index) => (
            <div key={index} className="row mb-4 align-items-center">
              <div className="col-md-2">
                <img src={`uploads/${item.product.image}`} className="img-fluid rounded-3" alt={item.product.name} />
              </div>
              <div className="col-md-3">
                <h6 className="text-muted">{item.product.name}</h6>
              </div>
              <div className="col-md-3">
                <span className="quantity fw-bold fs-4">{item.quantity}</span>
              </div>
              <div className="col-md-2">
                <h6>€{(item.product.price / 100).toFixed(2)}</h6>
              </div>
              <div className="col-md-2">
                <h6>€{((item.product.price / 100) * item.quantity).toFixed(2)}</h6>
              </div>
            </div>
          ))}
        </div>
        <div className="col-lg-4 bg-grey p-5">
          <h3 className="fw-bold mb-5 mt-2 pt-1">Synthèse</h3>
          <div className="d-flex justify-content-between mb-4">
            <h5 className="text-uppercase">Total</h5>
            <h5>€{(total / 100).toFixed(2)}</h5>
          </div>
          <button onClick={handleCheckout} className="btn btn-dark">VALIDER LE PANIER</button>

        </div>
      </div>
    ) : (
      <p>Le panier est vide.</p>
    )}
  </div>
);
};

export default CartPage;