// src/context/SessionContext.tsx
import React, { createContext, useState, ReactNode } from 'react';

interface SessionContextProps {
  isLoggedIn: boolean;
  logIn: () => void;
  logOut: () => void;
}

export const SessionContext = createContext<SessionContextProps>({ isLoggedIn: false, logIn: () => {}, logOut: () => {} });

interface SessionProviderProps {
  children: ReactNode;
}

export const SessionProvider: React.FC<SessionProviderProps> = ({ children }) => {
  const [isLoggedIn, setIsLoggedIn] = useState<boolean>(false);

  const logIn = () => {
    setIsLoggedIn(true);
  };

  const logOut = () => {
    setIsLoggedIn(false);
  };

  return (
    <SessionContext.Provider value={{ isLoggedIn, logIn, logOut }}>
      {children}
    </SessionContext.Provider>
  );
};
