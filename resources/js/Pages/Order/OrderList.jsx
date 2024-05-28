import React from 'react';
import {Link} from "@inertiajs/react";
import { Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'; // Import the layout

export default function OrderList({ orders, auth }) {
  return (
    <AuthenticatedLayout
        user={auth.user}
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}>
      <Head title="Orders" />
        <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg py-2">
      <h2 className="text-center">Orders
        <Link href="/orders/create" className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded float-right">
          Create Order
        </Link>
      </h2>
      <ul className="w-3/4 py-2 mx-auto">
        {orders.map((order) => (
          <li key={order.id} className="w-full space-x-2 mt-4">
            {/* Optional icon can be added here */}
            <div className="flex justify-between items-center mb-4" >
              <div className="flex justify-between items-center">
                <div>
                  <Link href={`/orders/${order.id}`}>
                    <span className="text-gray-800">Order #{order.id}</span>
                  </Link>
                  <small className="ml-2 text-sm text-gray-600">{new Date(order.created_at).toLocaleString()}</small>
                </div>
              </div>
              <p className="mt-4 text-lg text-gray-900">{order.user.name}</p>
            </div>
          </li>
        ))}
      </ul>
                    </div>
                    </div>
            </div>
   </AuthenticatedLayout>
  );
}
