export default function ErrorPage({ status,message }) {
    const title = {
        503: '503: Service Unavailable',
        500: '500: Server Error',
        404: '404: Page Not Found',
        403: '403: Forbidden',
    }[status]

    
    return (

        <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div className="text-center">
                <h1>{title}</h1>
                <div>{message}</div>
            </div>


        </div>

    )
}