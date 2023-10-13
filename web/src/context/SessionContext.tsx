import React, { createContext, useState, useEffect, ReactNode } from 'react';

interface SessionContextProps {
  isLoggedIn: boolean;
  user : User | null;
}
interface  User {
  id: number;
  email: string;
  roles: string[];
}

export const SessionContext = createContext<SessionContextProps>({ isLoggedIn: false, user: null });

interface SessionProviderProps {
  children: ReactNode;
}

export const SessionProvider: React.FC<SessionProviderProps> = ({ children }) => {
  const [isLoggedIn, setIsLoggedIn] = useState<boolean>(false);
  const [user, setUser] = useState<User | null>(null);
  const fetchWhoAmI = async () => {
    try {
       fetch('http://127.0.0.1:8000/whoami',{credentials:'include'}).then(async response => {
      console.log(response);
      
      if (response.ok) {
        const data = await response.json();
        console.log(data);
        
        if (data.id) {
          setIsLoggedIn(true);
          setUser(data);
          console.log('User is logged in:', data);
          
        }
      }})
    } catch (error) {
      console.error('Failed to fetch whoami:', error);
    }
  };

  useEffect(() => {
    fetchWhoAmI();
  }, []);

  return (
    <SessionContext.Provider value={{ isLoggedIn, user }}>
      {children}
    </SessionContext.Provider>
  );
};
