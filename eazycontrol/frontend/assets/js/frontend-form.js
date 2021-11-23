let $spinner = $('<div class="spinner-wrapper"><div class="spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>')
let error = {
    'status': false,
    'type': 'error',
    'title': '',
    'errors': []
};
let success = {
    'status': false,
    'type': 'success',
    'title': 'Your email was sent successfully',
}
function initFrontendForm()
{
    $('.frontend-form form.form').each(function ()
    {
        $(this).on('submit', function (event)
        {
            event.preventDefault();
            let $this = $(this);
            let $parent = $this.parents('.frontend-form')
            $parent.append($spinner);
            let action = $this.attr('action');
            let data = new FormData($this[0]);
            axios.post(action, data)
                .then(function (response) {
                    let result = response.data.result
                    if (response.data.status) {
                        success['status'] = true;
                        $this[0].reset();
                        frontendFormAlert($parent, success)
                    }
                    else
                    {
                        error['status'] = true;
                        error['title'] = result.title
                        error['errors'] = []
                        for (let child in result.children) {
                            let errors = result.children[child]['errors']
                            if (errors.length)
                            {
                                error['errors'].push([child, errors[0]['message']])
                            }
                        }
                        frontendFormAlert($parent, error)
                    }
                })
        });
    });
}

function frontendFormAlert($parent, result)
{
    $parent.find('.frontend-form-alert').html('');
    $parent.find($spinner).remove();
    if (result['status'])
    {
        let alertElement = '';
        if (result['type'] == 'success') {
            alertElement = '<div class="alert alert-success" role="alert"><h5>Success</h5><p>' + result['title'] + '</p></div>'
        }
        else if (result['type'] == 'error')
        {
            console.log(result.errors)
            alertElement = '<div class="alert alert-danger" role="alert">' +
                '<h5>Error: ' + result['title'] + '</h5>';
            for (let error in result.errors) {
                console.log(error)
                alertElement = alertElement + '<hr><p><b>' + result.errors[error][0] + '</b>' + result.errors[error][1] + '</p>';
            }
            alertElement = alertElement + '</div>';
        }
        $parent.find('.frontend-form-alert').append($(alertElement))
    }
}

$(document).ready(function ()
{
    initFrontendForm();
});
