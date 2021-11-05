import axios from 'axios'

export default{
    state: {

    },
    mutations: {

    },
    actions: {
        signup(commit, payload) {
            console.log(payload)
            axios.post('http://127.0.0.1:8000/register', payload)
            .then((res) => {
                alert('Signup Success')
                return res.data
            })
            .catch(() => {
                console.log('Signup Fail.')
            })
            
        }
    }
}