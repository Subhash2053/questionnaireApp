import SecondaryButton from '@/Components/SecondaryButton';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function List({ auth }) {
    const { exams } = usePage().props;
    const data = exams;


    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Exam</h2>}
        >
            <Head title="Exam" />
            <div className="py-12">

                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                    <Link
                        href={route("exam.create")}
                        
                    >
                        <SecondaryButton className="ml-3">
                            Create
                        </SecondaryButton>
                    </Link>
                    <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                        <div className="overflow-x-auto bg-white rounded shadow">

                            <table className="w-full whitespace-nowrap">
                                <thead className="text-white bg-gray-600">
                                    <tr className="font-bold text-left">
                                        <th className="px-6 pt-5 pb-4">#</th>
                                        <th className="px-6 pt-5 pb-4">Title</th>
                                        <th className="px-6 pt-5 pb-4">Expiry Date</th>
                                        <th className="px-6 pt-5 pb-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {data.map(({ id, title, expiry_date }) => (
                                        <tr key={id} className="">
                                            <td className="border-t">
                                                <Link
                                                    href={route("exam.edit", id)}
                                                    className="flex items-center px-6 py-4 focus:text-indigo-700 focus:outline-none"
                                                >
                                                    {id}
                                                </Link>
                                            </td>
                                            <td className="border-t">
                                                <Link
                                                    href={route("exam.edit", id)}
                                                    className="flex items-center px-6 py-4 focus:text-indigo-700 focus:outline-none"
                                                >
                                                    {title}
                                                </Link>
                                            </td>
                                            <td className="border-t">
                                                <Link
                                                    tabIndex="1"
                                                    className="flex items-center px-6 py-4"
                                                    href={route("exam.edit", id)}
                                                >
                                                    {expiry_date}
                                                </Link>
                                            </td>
                                            <td className="border-t">
                                         

                                                <Link
                                                    tabIndex="2"
                                                    className="px-4 py-2 text-sm text-white bg-blue-500 rounded"
                                                    href={route("exam.send", id)}
                                                >
                                                    Send Via Email
                                                </Link>
                                            </td>
                                        </tr>
                                    ))}
                                    {data.length === 0 && (
                                        <tr>
                                            <td
                                                className="px-6 py-4 border-t"
                                                colSpan="4"
                                            >
                                                No Exam found.
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </AuthenticatedLayout>
    );
}
