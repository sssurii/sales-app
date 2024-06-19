import React, { useState, useEffect } from 'react';
import axios from 'axios'; // Assuming you're using Axios for API requests
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from "@inertiajs/react";

export default function ShowFoodItem({auth}) {
  const [name, setName] = useState('');
  const [description, setDescription] = useState('');
  const [price, setPrice] = useState(0);
  const [category, setCategory] = useState('');
  const [availability, setAvailability] = useState(true); // Default availability
  const [image, setImage] = useState(null); // Assuming image is a file object
  const [isLoading, setIsLoading] = useState(false); // Track loading state
  const [errors, setErrors] = useState({}); // Track any errors during form submission
    const [successMessage, setSuccessMessage] = useState(''); // Track success message

    // Get food item ID from URL (e.g., /food-items/1/edit)
    const foodItemId = window.location.pathname.split('/')[2];
console.log(foodItemId)
  useEffect(() => {
    const fetchFoodItem = async () => {
      setIsLoading(true);
      try {
        const response = await axios.get(`/api/food-items/${foodItemId}`);
        const data = response.data;
        setName(data.name);
        setDescription(data.description);
        setPrice(data.price);
        setCategory(data.category);
        setAvailability(data.availability);
        setImage(data.image); // Assuming image data is available in the response
      } catch (error) {
        console.error('Error fetching food item:', error);
      } finally {
        setIsLoading(false);
      }
    };

    if (foodItemId) {
      fetchFoodItem();
    }
  }, [foodItemId]); // Refetch food item data when foodItemId changes

  const onEditSuccess = (editedData) => {
    console.log('Food item edited successfully:', editedData);
        window.location.href = '/food-items';
  }

  return (
      <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Edit food item</h2>}
        >
            <Head title="Edit Food Item" />
    <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
        {successMessage && (
            <div className="col-span-2 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <p className="font-bold">Success</p>
                <p>{successMessage}</p>
            </div>
        )}
        {errors.message && (
            <div className="col-span-2 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p className="font-bold">Error</p>
                <p>{errors.message}</p>
            </div>
        )}
              <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div className="col-span-1">
          {image && (
            <img
              src={image}
              alt={name}
              className="w-48 h-48 mx-auto object-cover rounded-lg mb-4"
            />
          )}
          <h2 className="font-semibold text-xl text-gray-800 leading-tight">{name}</h2>
          <p className="text-gray-700 mb-4">{description}</p>
          <div className="flex items-center space-x-2">
            <span className="inline-block bg-green-100 text-green-700 rounded-full py-1 px-2 text-sm font-medium">
              {category}
            </span>
            <span className={`inline-block ${availability ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'} rounded-full py-1 px-2 text-sm font-medium`}>
              {availability ? 'Available' : 'Unavailable'}
            </span>
          </div>
        </div>
        <div className="col-span-1">
          <p className="text-gray-700 font-bold mb-2">Price:</p>
          <span className="text-gray-900 text-xl font-semibold">{price}</span>
        </div>
      </div>
    </div>
      </div>
        </div>
    </div>
      </AuthenticatedLayout>
  );
}
