import React, { useState, useEffect } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from "@inertiajs/react";

export default function AddedFoodItemsTable({auth}) {
  const [foodItems, setFoodItems] = useState([]);
  const [isLoading, setIsLoading] = useState(false); // Track loading state

  useEffect(() => {
    const fetchFoodItems = async () => {
      setIsLoading(true);
      try {
        const response = await fetch('/api/food-items');
        const data = await response.json();
        setFoodItems(data);
      } catch (error) {
        console.error('Error fetching food items:', error);
      } finally {
        setIsLoading(false);
      }
    };

    fetchFoodItems();
  }, []); // Empty dependency array: fetch only once on component mount

    const handleDelete = async (id) => {
        try {
            await axios.delete(`/api/food-items/${id}`);
            setFoodItems(foodItems.filter((item) => item.id !== id));
        } catch (error) {
            console.error('Error deleting food item:', error);
        }
    }

  return (
      <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Food items</h2>}
        >
            <Head title="Food Items" />
    <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg py-2">
            <a href="/foodItem/create" className="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Add New Food Item
            </a>
        </div>
      <table className="w-full min-w-full text-left overflow-hidden">
        <thead>
          <tr className="bg-gray-50 border-b border-gray-200">
            <th scope="col" className="px-6 py-3 text-sm font-medium text-gray-700">
              Image
            </th>
            <th scope="col" className="px-6 py-3 text-sm font-medium text-gray-700">
              Name
            </th>
            <th scope="col" className="px-6 py-3 text-sm font-medium text-gray-700">
              Description
            </th>
            <th scope="col" className="px-6 py-3 text-sm font-medium text-gray-700">
              Category
            </th>
            <th scope="col" className="px-6 py-3 text-sm font-medium text-gray-700">
              Price
            </th>
            <th scope="col" className="px-6 py-3 text-sm font-medium text-gray-700">
              Availability
            </th>
              <th scope="col" className="px-6 py-3 text-sm font-medium text-gray-700">
                Actions
                </th>
          </tr>
        </thead>
          { isLoading ? (
              <p className="text-gray-500">Loading food items...</p>
            ) : !foodItems || foodItems.length === 0 ? (
              <p className="text-gray-500">No food items added yet.</p>
            ) : (
            <tbody>
              {foodItems.map((item) => (
                <tr key={item.id} className="border-b border-gray-200 hover:bg-gray-100">
                  <td className="px-6 py-4 whitespace-nowrap">
                    {item.image ? (
                      <img
                        className="w-10 h-10 rounded-full object-cover mx-auto"
                        src={item.image} // Assuming image URL or path is stored in "image" property
                        alt={item.name}
                      />
                    ) : (
                      <p className="text-gray-500">No Image</p>
                    )}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">{item.name}</td>
                  <td className="px-6 py-4 whitespace-nowrap">{item.description}</td>
                  <td className="px-6 py-4 whitespace-nowrap">{item.category}</td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    ${item.price}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    {item.availability ? 'Available' : 'Unavailable'}
                  </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                        <button
                        type="button"
                        className="text-indigo-600 hover:text-indigo-900 mr-2"
                        onClick={handleDelete(item)}
                        >
                        Remove
                        </button>

                        <a href={`/foodItem/${item.id}/edit`} className="text-indigo-600 hover:text-indigo-900">Edit</a>
                    </td>
                </tr>
              ))}
            </tbody>
          )}
      </table>
    </div>
    </div>
      </AuthenticatedLayout>
  );
}
