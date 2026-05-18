import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Dashboard({ auth, shop, products }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        {shop.name} - Seller Dashboard
                    </h2>
                    <Link
                        href={route('products.create')}
                        className="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition"
                    >
                        Add New Product
                    </Link>
                </div>
            }
        >
            <Head title="Seller Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div className="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                            <h3 className="text-gray-500 text-sm font-medium">Total Products</h3>
                            <p className="text-2xl font-bold">{products.length}</p>
                        </div>
                        <div className="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                            <h3 className="text-gray-500 text-sm font-medium">Total Sales</h3>
                            <p className="text-2xl font-bold">0</p>
                        </div>
                        <div className="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                            <h3 className="text-gray-500 text-sm font-medium">Shop Rating</h3>
                            <p className="text-2xl font-bold">N/A</p>
                        </div>
                    </div>

                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h3 className="text-lg font-semibold mb-4">Your Products</h3>
                            {products.length === 0 ? (
                                <div className="text-center py-12">
                                    <p className="text-gray-500">You haven't added any products yet.</p>
                                    <Link
                                        href={route('products.create')}
                                        className="text-indigo-600 hover:underline mt-2 inline-block"
                                    >
                                        Create your first listing
                                    </Link>
                                </div>
                            ) : (
                                <div className="overflow-x-auto">
                                    <table className="w-full text-left">
                                        <thead>
                                            <tr className="border-b">
                                                <th className="pb-3 font-medium text-gray-600">Product</th>
                                                <th className="pb-3 font-medium text-gray-600">Price</th>
                                                <th className="pb-3 font-medium text-gray-600">Stock</th>
                                                <th className="pb-3 font-medium text-gray-600">Status</th>
                                                <th className="pb-3 font-medium text-gray-600">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {products.map((product) => (
                                                <tr key={product.id} className="border-b last:border-0 hover:bg-gray-50 transition">
                                                    <td className="py-4">
                                                        <div className="flex items-center">
                                                            <div className="h-10 w-10 bg-gray-100 rounded mr-3"></div>
                                                            <span className="font-medium">{product.title}</span>
                                                        </div>
                                                    </td>
                                                    <td className="py-4">${product.price}</td>
                                                    <td className="py-4">{product.quantity}</td>
                                                    <td className="py-4">
                                                        <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                                                            product.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'
                                                        }`}>
                                                            {product.status}
                                                        </span>
                                                    </td>
                                                    <td className="py-4 text-indigo-600 hover:underline cursor-pointer font-medium">
                                                        <Link href={route('products.edit', product.id)}>Edit</Link>
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
