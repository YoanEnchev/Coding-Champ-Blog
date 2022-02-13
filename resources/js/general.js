let general = {
    'init': () => {
        $('.ajax-confirm-btn').click((e) => {
            e.preventDefault();
            let button = $(e.target);
            let form = button.closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: form.attr('data-text'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
              }).then((result) => {
                if (result.isConfirmed) {
                  form.submit();
                }
              })
        });
    }
};

export default general;