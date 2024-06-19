import React, { useState, useEffect } from 'react';
import axios from 'axios'; // Assuming you're using Axios for API requests
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from "@inertiajs/react";

export default function EditFoodItemForm({auth}) {
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

  const handleSubmit = async (e) => {
    e.preventDefault();

    const formData = new FormData(); // For handling file uploads
    formData.append('name', name);
    formData.append('description', description);
    formData.append('price', price);
    formData.append('category', category);
    formData.append('availability', availability);

    if (image) {
      formData.append('image', image); // Add image to form data (optional)
    }

    try {
      setIsLoading(true);
      const response = await axios.post(`/api/food-items/${foodItemId}`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data', // Required for file uploads
        },
      });

      onEditSuccess(response.data); // Call callback function with edited data
      // Optionally, display success message, redirect, etc.

    } catch (error) {
      if (error.response) {
        setErrors(error.response.data.errors); // Set form validation errors
      } else {
        console.error('Error editing food item:', error);
      }
    } finally {
      setIsLoading(false);
    }
  };

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
    <form onSubmit={handleSubmit} className="grid grid-cols-1 md:grid-cols-2 gap-4">
      {isLoading && <p className="text-gray-500">Loading food item...</p>}
      {errors && (
        <div className="col-span-2">
          <ul className="list-disc text-red-500 space-y-1">
            {Object.keys(errors).map((errorKey) => (
              <li key={errorKey}>{errors[errorKey]}</li>
            ))}
          </ul>
        </div>
      )}
  <div className="col-span-1">
    <div className="mb-4">
      <label htmlFor="name" className="block text-gray-700 font-bold mb-2">
        Name
      </label>
      <input
        id="name"
        type="text"
        value={name}
        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        onChange={(e) => setName(e.target.value)}
        required
      />
    </div>
    <div className="mb-4">
      <label htmlFor="description" className="block text-gray-700 font-bold mb-2">
        Description
      </label>
      <textarea
        id="description"
        value={description}
        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        onChange={(e) => setDescription(e.target.value)}
        rows={5}
        required
      />
    </div>
    <div className="mb-4">
      <label htmlFor="price" className="block text-gray-700 font-bold mb-2">
        Price
      </label>
      <input
        id="price"
        type="number"
        value={price}
        min={0}
        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        onChange={(e) => setPrice(e.target.value)}
        required
      />
    </div>
  </div>
  <div className="col-span-1">
    <div className="mb-4">
      <label htmlFor="category" className="block text-gray-700 font-bold mb-2">
        Category
      </label>
      <select
        id="category"
        value={category}
        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        onChange={(e) => setCategory(e.target.value)}
        required
      >
        {/* Populate options for category based on your data */}
        <option value="">Select Category</option>
        <option value="appetizer">Appetizer</option>
        <option value="main_course">Main Course</option>
        <option value="dessert">Dessert</option>
        {/* ... more options ... */}
      </select>
    </div>
    <div className="mb-4">
      <label htmlFor="availability" className="block text-gray-700 font-bold mb-2">
        Availability
      </label>
      <div className="flex items-center">
        <input
          id="availability"
          type="checkbox"
          checked={availability}
          onChange={(e) => setAvailability(e.target.checked)}
          className="mr-2"
        />
        <label htmlFor="availability" className="text-gray-700">
          Available
        </label>
      </div>
    </div>
    <div className="mb-4">
      <label htmlFor="image" className="block text-gray-700 font-bold mb-2">
        Image (Optional)
      </label>
      <input
        id="image"
        type="file" // For image upload
        className="shadow appearance-none border
            rounded w-full py-2 px-3 text-gray-700 leading-tight
            focus:outline-none focus:shadow-outline"
        onChange={(e) => setImage(e.target.files[0])}
        />
    </div>
    </div>
    <div className="col-span-2">
        <button
            type="submit"
            className="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
        >
            Save Changes
        </button>
    </div>
    </form>
      </div>
        </div>
    </div>
      </AuthenticatedLayout>
  );
}
