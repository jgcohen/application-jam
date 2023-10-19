import React, { createContext, useState, ReactNode } from 'react';

interface SessionContextProps {
  user : User | null;
  setUser : React.Dispatch<React.SetStateAction<User | null>>;
}
interface  User {
  email: string;
}

export const SessionContext = createContext<SessionContextProps>({  user: null ,setUser: () => {} });

interface SessionProviderProps {
  children: ReactNode;
}

export const SessionProvider: React.FC<SessionProviderProps> = ({ children }) => {
  const [user, setUser] = useState<User | null>(null);

  

  return (
    <SessionContext.Provider value={{ user,setUser }}>
      {children}
    </SessionContext.Provider>
  );
};
