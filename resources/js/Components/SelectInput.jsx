//create select input component

import React from 'react';
import {ChevronDownIcon} from "@heroicons/react/16/solid/index.js";
import InputLabel from "@/Components/InputLabel.jsx";

const SelectInput = ({ label, options, value, onChange, error }) => {
    return (
        <div className="w-full">
            {label && <InputLabel>{label}</InputLabel>}

            <div className="relative mt-1">
                <select
                    value={value}
                    onChange={onChange}
                    className={`block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm ${error ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : ''}`}
                >
                    <option value="">Select an option</option>
                    {options.map((option) => (
                        <option key={option.value} value={option.value}>
                            {option.label}
                        </option>
                    ))}
                </select>

                <div className="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <ChevronDownIcon className="w-5 h-5 text-gray-400" aria-hidden="true" />
                </div>
            </div>

            {error && <InputError>{error}</InputError>}
        </div>
    );
}

export default SelectInput;
