export default function handle(toast, error) {
    console.log(error)

    if (error.response.status === 401) {
        location.href = '/hwba/sign-in'
    }

    if (error.response.status === 422) {
        for (let item of Object.values(error.response.data.errors)) {
            for (let message of item) {
                toast.error(message)
            }
        }
    } else {
        console.log(error)
        toast.error('Упс, что-то пошло не так. Обратитесь к разработчику')
    }
}
