//generate simple hello world component
import React from 'react';
import { Head } from '@inertiajs/react';

import Guest from "@/Layouts/GuestLayout.jsx";
// Code: HelloWorld Page
export default function HelloWorld() {
    return (
        <Guest>
            <Head title="Hello World" />
            <div>
                <h1 className="mb-8 text-3xl font-bold">Hello World</h1>
                <p>This is a simple hello world component.</p>
            </div>
        </Guest>
    );
}
