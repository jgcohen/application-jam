import React, { useContext } from 'react';
import { Link } from 'react-router-dom';
import { SessionContext } from '../context/SessionContext';

const NavBar = () => {
  if (!SessionContext) {
    throw new Error('NavBar must be used within a SessionProvider');
}
const { isLoggedIn } = useContext(SessionContext);

const handleLogout = async () => {
    window.location.href = 'http://127.0.0.1:8000/logout';
};
  return (
    <nav>
      <ul>
        <li>
          <Link to="/">Home</Link>
        </li>
        <li>
          <Link to="/cart">Cart</Link>
        </li>
        <li>
                    {!isLoggedIn ? (
                        <a href="http://127.0.0.1:8000/login" target="_blank" rel="noopener noreferrer">
                            Login
                        </a>
                    ) : (
                        <a onClick={handleLogout} style={{ cursor: 'pointer' }}>
                            Logout
                        </a>
                    )}
                </li>
      </ul>
    </nav>
  );
};

export default NavBar;