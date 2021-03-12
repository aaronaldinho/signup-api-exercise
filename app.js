const API_POST_URL = 'http://localhost:3000/api/login.php'; // declare your endpoint
const modal = new bootstrap.Modal(document.querySelector('.modal'));

/**
 * Form submit
 */
document.querySelector('.signup-form form').addEventListener('submit', e => {
    e.preventDefault(); // prevent reload current page on submit

    // get form values
    const data = {
            username: document.querySelector('[name=username]').value,
            email: document.querySelector('[name=email]').value,
            normalPassword: document.querySelector('[name=password]').value,
            confirmPassword: document.querySelector('[name=confirm_password]').value,
            checkbox: document.querySelector('[name=checkbox]').checked,

        }
        // send values to api
    fetch(API_POST_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            console.log(res)

            modal.show();
        });
});

// let i = [1, 2, 3, 4, 5, 6]
// i['success'] = true;