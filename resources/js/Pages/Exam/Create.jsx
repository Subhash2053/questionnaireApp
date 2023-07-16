
import SecondaryButton from '@/Components/SecondaryButton';
import TextInput from '@/Components/TextInput';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

import { Head, Link, router, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function Create({ auth }) {
    const { data, setData, errors, post } = useForm({

        title: "",
        expiry_date: "",

    });


    const handleChange = async (event) => {
        let value = event.target.value;

        let name = event.target.name;

        setData(values => ({
            ...values,
            [name]: value,
        }))
    };

    const handleSubmit = (e) => {
        e.preventDefault()
        post(route('exam.store'), data)

    };
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Exam Create</h2>}
        >
            <Head title="Exam" />
            <div className="py-12">

                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                        <div className="overflow-x-auto bg-white rounded shadow">
                            <form name="createForm" onSubmit={handleSubmit}>
                                <div className="flex flex-col">
                                    <div className="mb-4">
                                        <label className="">Title</label>
                                        <TextInput
                                            type="text"
                                            className="w-full px-4 py-2"
                                            label="Title"
                                            name="title"
                                            value={data.title}
                                            onChange={handleChange}
                                        />
                                        <span className="text-red-600">
                                            {errors.title}
                                        </span>

                                    </div>

                                    <div className="mb-4">
                                        <label className="">Expiry Date</label>
                                        <input
                                            type="date"
                                            className="w-full px-4 py-2"
                                            label="Expiry Date"
                                            name="expiry_date"
                                            value={data.expiry_date}
                                            onChange={handleChange}
                                        />
                                        <span className="text-red-600">
                                            {errors.expiry_date}
                                        </span>
                                    </div>

                                    <div className="mb-4">
                                        <SecondaryButton type="submit">
                                            Generate
                                        </SecondaryButton>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </AuthenticatedLayout>
    );
}
