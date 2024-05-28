import React from 'react';
import {Head} from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";

export default function OrderDetails({ order, auth }) {
  return (
      <AuthenticatedLayout
        user={auth.user}
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Order Details</h2>}>
        <Head title="Orders" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                      <h2 className="text-center font-bold py-2">Order Details: {order.id}</h2>
                      {/* Display order details (customer, items, total price, etc.) */}
                      <div>
                        {console.log(order)}
                        <div className="flex justify-between items-center mb-4">
                          <span className="text-gray-800">Customer Name:</span>
                          <span className="text-gray-600">{order.user.name}</span>
                        </div>
                        {/* Order items details (iterate over items array) */}
                        <div>
                          <h3>Order Items:</h3>
                          <ul>
                            {order.order_items.map((item) => (
                              <li key={item.id} className="flex justify-between items-center mb-2">
                                <span className="text-gray-800">{item.food_item.name}</span>
                                <span className="text-gray-600">{item.quantity} x {item.price}</span>
                              </li>
                            ))}
                          </ul>
                        </div>
                        {/* Total price */}
                        <div className="flex justify-between items-center mt-4">
                          <span className="text-gray-800">Total Price:</span>
                          <span className="text-gray-600">{order.total_price}</span>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
      </AuthenticatedLayout>
  );
}
