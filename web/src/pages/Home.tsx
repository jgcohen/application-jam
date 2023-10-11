import React, { useState, useEffect, useContext } from 'react';
import Slider from '@mui/material/Slider';
import { CartContext } from '../context/CartContext';
import { SessionContext } from '../context/SessionContext';
export interface Category {
    id: number;
    name: string;
  }

export interface Product {
    id: number;
    name: string;
    price: number;
    categories: Category[];
    image: string;
  }  

const Home = () => {
  const [products, setProducts] = useState([] as Product[]);
  const [categories, setCategories] = useState<Category[]>([]);
  const [filter, setFilter] = useState('price_asc');
  const [minPrice, setMinPrice] = useState(3.1);
  const [maxPrice, setMaxPrice] = useState(5.9);
  const [selectedCategories, setSelectedCategories] = useState<number[]>([]);
  const [sliderValues, setSliderValues] = useState([minPrice, maxPrice]);
  const cartContext = useContext(CartContext);
    // const sessionContext = useContext(SessionContext);
    if (!cartContext) {
        throw new Error("Expected to be rendered within a CartProvider");
      }
    const { cart, setCart } = cartContext;

  useEffect(() => {
        fetch('http://localhost:8000/products')
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
          })
          .then(data => {
            if (Array.isArray(data['hydra:member'])) {
              setProducts(data['hydra:member']);
            } else {
              console.error('Data is not an array:', data);
            }
          })
          .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
          });

    fetch('http://localhost:8000/categories')
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok ' + response.statusText);
      }
      return response.json();
    })
    .then(data => {
        if (Array.isArray(data['hydra:member'])) {
            setCategories(data['hydra:member']);
        } else {
            console.error('Data is not an array:', data);
        }
        }
    )
    .catch(error => {
      console.error('There has been a problem with your fetch operation:', error);
    });

    }
    , []);
        
    useEffect(() => {
        const savedCart = localStorage.getItem('cart');
        
        if (savedCart) {
            setCart(JSON.parse(savedCart));
            console.log('Restoring cart from localStorage:', JSON.parse(savedCart));
        }
    }, []);
    useEffect(() => {
        if (cart.length > 0) {
            console.log('Updating localStorage:', cart);
            localStorage.setItem('cart', JSON.stringify(cart));
        } else {
            console.log('Cart is empty, not updating localStorage');
        }
    }, [cart]);
    
        
  const handleFilterChange = (event: { target: { value: React.SetStateAction<string>; }; }) => {
    setFilter(event.target.value);
  };

  const handleCart = (product: Product, quantity: number) => {
    const existingProductIndex = cart.findIndex(cartItem => cartItem.product.id === product.id);
    if (existingProductIndex >= 0) {
        const newCart = [...cart];
        newCart[existingProductIndex].quantity = quantity;  
        console.log('setCart', newCart);
        
        setCart(newCart); 

    } else {
        setCart(prevCart => [...prevCart, { product, quantity }]);  
    }
};
  const handleCategoryChange = (categoryId: number) => {
    setSelectedCategories(prevSelectedCategories => {
      const isCategorySelected = prevSelectedCategories.includes(categoryId);
      if (isCategorySelected) {
        return prevSelectedCategories.filter(id => id !== categoryId);
      } else {
        return [...prevSelectedCategories, categoryId];
      }
    });
  };

  const filteredProducts = products
  .filter(product => {
    if (product.price/100 < minPrice || product.price/100 > maxPrice) {
      return false;
    }
    if (selectedCategories.length === 0) {
      return true;
    }
    return product.categories.some(category => selectedCategories.includes(category.id));
  })
  .sort((a, b) => {
    switch (filter) {
      case 'price_asc':
        return a.price - b.price;
      case 'price_desc':
        return b.price - a.price;
      case 'name_asc':
        return a.name.localeCompare(b.name);
      case 'name_desc':
        return b.name.localeCompare(a.name);
      default:
        return 0;
    }
  });
  const handleSliderChange = (event, newValue) => {
    setSliderValues(newValue);
    setMinPrice(newValue[0]);
    setMaxPrice(newValue[1]);
  };
  return (
    <div className="container mt-5">
      <div className="row">
        <div className="col-4">
          <label className="slider-label">Gamme de prix</label>
          <Slider
  value={sliderValues}
  onChange={handleSliderChange}
  valueLabelDisplay="auto"
  min={3.1}
  max={5.9}  
  step={0.1}
/>
            <select value={filter} onChange={handleFilterChange} className="form-select my-2">
              <option value="price_asc">Prix croissant</option>
              <option value="price_desc">Prix décroissant</option>
              <option value="name_asc">Alphabétique</option>
              <option value="name_desc">Alphabétique Z A</option>
            </select>
            {categories?.map(category => (
              <div key={category.id} className="form-check my-2">
                <input
                  className="form-check-input"
                  type="checkbox"
                  value={category.id}
                  checked={selectedCategories?.includes(category.id)}
                  onChange={() => handleCategoryChange(category.id)}
                  id={`category-${category.id}`}
                />
                <label className="form-check-label" htmlFor={`category-${category.id}`}>
                  {category.name}
                </label>
              </div>
            ))}
        </div>
        <div className="col-8">
          <div className="row">
            {filteredProducts?.map(product => (
              <div key={product.id} className="m-2 col-3 card">
                <img src={`uploads/${product.image}`} alt={product.name} className="p-4 card-img-top" />
                <div className="card-body d-flex flex-column justify-content-between">
                  <h5 className="card-title">{product.name}</h5>
                  <p className="card-text">{ (product.price / 100).toFixed(2) } €</p>
                  <div className="row">
                    <div className="col">
                      <input type="number" defaultValue="1" min="1" id={`quantity-${product.id}`} className="form-control" />
                      <button
    onClick={() => handleCart(product, Number(document.getElementById(`quantity-${product.id}`)?.value))}
    className="mt-2 btn btn-dark">
    {cart.find(cartItem => cartItem.product.id === product.id) ? 'Modifier' : 'Ajouter'}
</button>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
);
}

export default Home;