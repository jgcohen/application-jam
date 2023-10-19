import React, { useContext, useEffect } from 'react';
import { CartContext } from '../context/CartContext';

const CheckoutSuccess = () => {
    const cartContext = useContext(CartContext);
    const  {setCart} = cartContext;
    useEffect(() => {
        setCart([]);
    }, [setCart]);
    return (
        <div>
        <h1> Merci pour votre achat ! </h1>
        </div>
    );
    };

export default CheckoutSuccess

