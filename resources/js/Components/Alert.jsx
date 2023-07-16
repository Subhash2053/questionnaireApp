import Swal from "sweetalert2"
import withReactContent from "sweetalert2-react-content";

export default function Alert({ type, message }) {
    const MySwal = withReactContent(Swal)
    return (

        MySwal.fire({
            position: 'middle',
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 1500
        })

    );
}
