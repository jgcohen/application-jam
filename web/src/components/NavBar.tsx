import React, { useContext, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { SessionContext } from '../context/SessionContext';
import { CartContext } from '../context/CartContext';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'font-awesome/css/font-awesome.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const NavBar = () => {
  if (!SessionContext) {
      throw new Error('NavBar must be used within a CartProvider');
  }

  if (!CartContext) {
      throw new Error('NavBar must be used within a CartProvider');
  }
  

  const { isLoggedIn } = useContext(SessionContext);
  const { cart } = useContext(CartContext);

  const handleLogout = async () => {
      window.location.href = 'http://127.0.0.1:8000/logout';
  };
  
  const totalItemsInCart = cart.reduce((total, cartItem) => total + cartItem.quantity, 0);

  return (
      <nav className="navbar navbar-expand-lg navbar-light bg-light">
          <Link className="navbar-brand" to="/">Application Jam</Link>
          <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span className="navbar-toggler-icon"></span>
          </button>
          <div className="collapse navbar-collapse" id="navbarNav">
              <ul className="navbar-nav">
                  <li className="nav-item">
                      <Link className="nav-link" to="/">Home</Link>
                  </li>
                  <li className="nav-item">
                      <Link className="nav-link" to="/cart">
                          <i className="fa fa-shopping-cart" aria-hidden="true"></i>
                        <span> {totalItemsInCart} </span> 
                      </Link> 
                  </li>
                  <li className="nav-item">
                      {!isLoggedIn ? (
                          <a className="nav-link" href="http://127.0.0.1:8000/login" target="_blank" rel="noopener noreferrer">
                              Login
                          </a>
                      ) : (
                          <a className="nav-link" onClick={handleLogout} style={{ cursor: 'pointer' }}>
                              Logout
                          </a>
                      )}
                  </li>
              </ul>
          </div>
      </nav>
  );
};

export default NavBar;