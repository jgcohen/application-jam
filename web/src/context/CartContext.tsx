import React, { createContext, useState, ReactNode } from 'react';
import { Product } from '../pages/Home';

interface CartItem {
    product: Product;
    quantity: number;
  }
  type Cart = CartItem[];

  interface CartContextProps {
    cart: Cart;
    setCart: React.Dispatch<React.SetStateAction<Cart>>;
  }
  
  export const CartContext = createContext<CartContextProps | undefined>(undefined);
  
  interface CartProviderProps {
    children: ReactNode;
  }
  
  export const CartProvider: React.FC<CartProviderProps> = ({ children }) => {
    const [cart, setCart] = useState<Cart>([]);
  
    return (
      <CartContext.Provider value={{ cart, setCart }}>
        {children}
      </CartContext.Provider>
    );
  };