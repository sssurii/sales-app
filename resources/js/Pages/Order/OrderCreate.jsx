import React, { useState, useEffect } from 'react';
//import { useHistory } from 'react-router-dom';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import {Head} from "@inertiajs/react";
import Dropdown from "@/Components/Dropdown.jsx";
import SelectInput from '@/Components/SelectInput'; // Assuming you have a SelectInput component

export default function OrderCreate({auth}) {
  const [customerId, setCustomerId] = useState('');
  const [customerOptions, setCustomerOptions] = useState([]);
  const [foodItems, setFoodItems] = useState([]); // Array to store selected food items
  const [items, setItems] = useState([]); // Array to store selected food items
  const [tables, setTables] = useState([1,2,3,4,5]); // Array to store selected food items
  const [tableId, setTableId] = useState(''); // Array to store selected food items
  const [errors, setErrors] = useState({}); // To handle form errors
    const [subTotal, setSubTotal] = useState(0);
    const [tax, setTax] = useState(0);
    const [total, setTotal] = useState(0);

  //const history = useHistory();

  useEffect(() => {
    // Fetch customer data from your Laravel API
    const fetchCustomers = async () => {
      const response = await axios.get('/api/users');
      setCustomerOptions(response.data.map((customer) => ({ value: customer.id, label: customer.name })));
    };
    fetchCustomers();
  }, []);

  useEffect(() => {
    // Fetch customer data from your Laravel API
    const fetchFoodItems = async () => {
      const response = await axios.get('/api/food-items');
      setFoodItems(response.data);
    };
    fetchFoodItems();
  }, []);

  const handleItemChange = (newItemId) => {
    const newItem = foodItems.find((item) => item.id == newItemId);
    // Handle adding/removing items from the order
    setItems([...items, {...newItem, 'quantity': newItem.quantity || 1}]); // Update items state
  };


  const updateSubTotal = () => {
    let total = 0;
    items.forEach((item) => {
      total += item.price * item.quantity;
    });

    setSubTotal(total);
    setTax(total * 0.18);
    setTotal(total + (total * 0.18));
  }


  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const response = await axios.post('/api/orders', {
        user_id: customerId,
        table_id: tableId,
          sub_total: subTotal,
            tax: tax,
            total_price: total,
        items, // Array of selected food item objects
      });

      //history.push('/orders'); // Redirect to orders list after successful creation
    } catch (error) {
      if (error.response) {
        setErrors(error.response.data.errors);
      } else {
        console.error('Error creating order:', error);
      }
    }
  };

    function updateItemQuantity(item, quantity) {
        const newItems = items.map((i) => {
            if (i.id === item.id) {
                return {
                    ...i,
                    quantity: quantity,
                };
            }

            return i;
        });

        setItems(newItems);
        updateSubTotal();
    }

    return (
    <AuthenticatedLayout
        user={auth.user}
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}>
      <Head title="Create Order" />
        <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                        <form onSubmit={handleSubmit}>
        <div>
          <InputLabel htmlFor="user_id" value="Customer" />
          <SelectInput
            id="user_id"
            name="user_id"
            value={customerId}
            options={customerOptions}
            onChange={(e) => setCustomerId(e.target.value)}
            required
          />

          <InputError message={errors.user_id} className="mt-2" />
        </div>

        <div>
          <InputLabel htmlFor="table_id" value="Table" />
          <SelectInput
            id="table_id"
            name="table_id"
            value={tableId}
            options={tables.map((table) => ({ value: table, label: `Table no. ${table}` }))} // Assuming you have a table number
            onChange={(e) => setTableId(e.target.value)}
            required
          />

          <InputError message={errors.user_id} className="mt-2" />
        </div>

        <div className="mt-4 mb-2">
          {/* Implement logic for selecting food items (dropdown, list, etc.) */}
            <SelectInput
                label="Food Items"
                options={foodItems.map((item) => ({ value: item.id, label: item.name }))}
                value={items}
                onChange={(e) => handleItemChange(e.target.value)}
            />

          {/*<button onClick={() => handleItemChange({ name: 'Pizza', price: 10.00 })} type="button">*/}
          {/*  Add Pizza*/}
          {/*</button>*/}
          {/* ... buttons or components for other food items ... */}
          {items.length > 0 && (
            <ul className="mt-2">
              {items.map((item) => (
                  <li key={item.name} className="w-full md:w-1/2 p-2 border border-gray-200 rounded-md flex items-center justify-between">
                    <span className="text-gray-800">{item.name} - ${item.price}</span>
                    <div className="flex items-center">
                      <button
                        onClick={() => setItems(items.filter((i) => i.id !== item.id))}
                        type="button"
                        className="px-2 py-1 text-red-500 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 rounded-md"
                      >
                        Remove
                      </button>
                      <label className="ml-2 text-gray-700" htmlFor={`quantity-${item.id}`}>
                        Quantity:
                      </label>
                      <input
                        id={`quantity-${item.id}`}
                        type="number"
                        defaultValue={item.quantity || 1}
                        min={1}
                        max={100}
                        className="ml-2 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        onChange={(e) => updateItemQuantity(item, e.target.value)} // Update quantity function
                      />
                    </div>
                  </li>
                ))}
            </ul>
          )}
        </div>


        <div className="my-4-4 w-1/3 float-right">
            <InputLabel htmlFor="sub_total" value="Sub Total" />
            <input
                id="sub_total"
                name="sub_total"
                type="number"
                value={items.reduce((total, item) => total + (item.price * item.quantity), 0)}
                readOnly
                className="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
            <p className="text-sm text-gray-500">Subtotal is calculated based on the quantity of each item.</p>
            <InputLabel htmlFor="tax" value="Tax - 18%" />
            <input
                id="tax"
                name="tax"
                type="number"
                value={items.reduce((total, item) => total + (item.price * item.quantity), 0) * 0.18}
                readOnly
                className="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" //18% tax
            />
            <p className="text-sm text-gray-500">Tax is calculated based on the subtotal.</p>
            <InputLabel htmlFor="total" value="Total" />
            <input
                id="total"
                name="total"
                type="number"
                value={items.reduce((total, item) => total + (item.price * item.quantity), 0) * 1.18}
                readOnly
                className="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />

            <div className="flex items-center justify-end my-4">
              <PrimaryButton className="ms-4" disabled={!customerId || items.length === 0}>
                Create Order
              </PrimaryButton>
            </div>
        </div>
      </form>
                    </div>
                </div>
            </div>
    </AuthenticatedLayout>
  );
}
