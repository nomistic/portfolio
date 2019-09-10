const works = document.getElementById('works');

if (works) {
    works.addEventListener('click', e => {
        if (e.target.className === 'btn btn-danger delete-article') {
        if (confirm('Are you sure?')) {
            const id = e.target.getAttribute('data-id');

            fetch(`/work/delete/${id}`, {
                method: 'DELETE'
            }).then(res => window.location.reload());
        }
    }
});
}

const clients = document.getElementById('clients');

if (clients) {
    clients.addEventListener('click', e => {
        if (e.target.className === 'btn btn-danger delete-client') {
        if (confirm('Are you sure?')) {
            const id = e.target.getAttribute('data-id');

            fetch(`/client/delete/${id}`, {
                method: 'DELETE'
            }).then(res => window.location.reload());
        }
    }
});
}




