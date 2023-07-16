
import DangerButton from '@/Components/DangerButton';
import InputLabel from '@/Components/InputLabel';
import Modal from '@/Components/Modal';
import SecondaryButton from '@/Components/SecondaryButton';
import TextInput from '@/Components/TextInput';
import StudentLayout from '@/Layouts/StudentLayout';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';

export default function Fill() {
    const { questions, user,exam } = usePage().props;
    const { Physics, Chemistry } = questions;

    const [data, setData] = useState({
        password: '',
        email: ''
    });

    const [askPassword, setAskPassword] = useState(false);

    useEffect(() => {
        setData(values => ({
            ...values,
            email: user.email,
        }))


    }, [user])



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
        
          
      
            fetch(`/api/exam/submit/${exam.id}`, {
                method: 'post',
                body: JSON.stringify(data),
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => response.json())
            .then(json => {
                alert(json.message)
               setAskPassword(false);
            })
            
        

        //router.post('/exam/submit', data)
    };

    const handleSubmitButton =()=>{
        setAskPassword(true)
    }
    

    const closeModal = () => {
        setAskPassword(false);

        setData(values => ({
            ...values,
            password: '',
        }))
    };

    const loadForm = (question) => {
        return question.map(({ id, question, options }) => {
            let questionId = id;
            return <div key={id} className="mb-4">
                <label className="">{question}</label>
                <br />

                {
                    options && options.map(({ id, option }) => (
                        <div key={id} >  <label className="px-2">{option}</label>
                            <input

                                type="radio"
                                className="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                label={option}
                                name={questionId}
                                value={id}
                                onChange={handleChange}
                            />
                            <br />
                        </div>
                    ))
                }


            </div>
        })
    }

    return (
        <StudentLayout

        >
            <header className="bg-white shadow">
                <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 font-bold">Hi, {user && user.name}<br />
                    Please complete this exam and submit.
                </div>
            </header>
            <div className="py-12 px-5">
                <form name="createForm" >
                    <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <section className='space-y-6 max-w-xl'>
                            <h5 className='font-bold'>Physics</h5>

                            {Physics && loadForm(Physics)}

                        </section>
                    </div>
                    <hr>
                    </hr>
                    <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <section className='space-y-6 max-w-xl'>
                            <h5 className='font-bold'>Chemistry</h5>

                            {Chemistry && loadForm(Chemistry)}

                        </section>
                    </div>

                    <div className="mb-4 m-5">
                        <SecondaryButton onClick={handleSubmitButton} type="button">
                            Submit
                        </SecondaryButton>
                    </div>
                </form>
            </div>



            <Modal show={askPassword} onClose={closeModal}>
                <form onSubmit={handleSubmit} className="p-6">
                    <h2 className="text-lg font-medium text-gray-900">
                        Please enter your password to submit exam
                    </h2>



                    <div className="mt-6">
                        <InputLabel htmlFor="password" value="Password" className="sr-only" />

                        <TextInput
                            id="password"
                            type="password"
                            name="password"
                            value={data.password}
                            onChange={handleChange}
                            className="mt-1 block w-3/4"
                            isFocused
                            placeholder="Password"
                        />


                    </div>

                    <div className="mt-6 flex justify-end">
                        <SecondaryButton onClick={closeModal}>Cancel</SecondaryButton>

                        <DangerButton className="ml-3">
                            Proceed
                        </DangerButton>
                    </div>
                </form>
            </Modal>
        </StudentLayout>
    );
}
