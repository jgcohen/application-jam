import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App.tsx'
import './index.css'
import { SessionProvider } from './context/SessionContext.tsx'
import { CartProvider } from './context/CartContext.tsx'

ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>

      <SessionProvider> 
        <CartProvider>
    <App />
        </CartProvider>
    </SessionProvider>
  </React.StrictMode>,
)
