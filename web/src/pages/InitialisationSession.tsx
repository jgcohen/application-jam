import React, { useContext, useEffect } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import { SessionContext } from '../context/SessionContext';

function InitialisationSession() {
  const location = useLocation();
  const navigate = useNavigate();
  const { setUser } = useContext(SessionContext);

  useEffect(() => {
    const queryParams = new URLSearchParams(location.search);
    const email = queryParams.get('email');

    if (email) {
      setUser({ email: email});
      
      navigate('/');
    }
  }, [location, setUser, navigate]);

  return null; 
}

export default InitialisationSession;