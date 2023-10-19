import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Home from './pages/Home';
import Cart from './pages/Cart';
import './App.css';
import NavBar from './components/NavBar';
import 'bootstrap/dist/css/bootstrap.min.css';
import CheckoutError from './pages/CheckoutError';
import CheckoutSuccess from './pages/CheckoutSucces';
import Footer from './components/Footer';
import InitialisationSession from './pages/InitialisationSession';



function App() {
  return (
      <Router>
        <NavBar />
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/cart" element={<Cart />} />
          <Route path="/checkout_error" element={<CheckoutError />} />
          <Route path="/checkout_success" element={<CheckoutSuccess />} />
          <Route path="/initialisationSession" element={<InitialisationSession />} />
        </Routes>
        <Footer />
      </Router>
  );
}

export default App;