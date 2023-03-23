
    $(document).ready(
        function()
        {

            $('.application_options .js-create-address-book').click(
                function(e)
                {

                    let button = $('.application_options .js-create-address-book');

                    if($(this).attr('disable') === 'disable')
                    {
                        e.preventDefault();
                        return;
                    }

                    let bookNameField = $('.application_options input[name="title"]');
                    bookNameField.removeClass('is-invalid');

                    let title = bookNameField.val().trim();

                    if(title.length === 0)
                    {
                        bookNameField.addClass('is-invalid');
                        e.preventDefault();
                        return;
                    }

                    button.attr('disable', 'disable')
                        .find('span.spinner-border')
                        .removeClass('spinner-hide')
                    ;

                    $.post(
                        options.url,
                        {
                            title: title
                        },
                        function(response)
                        {

                            if(response['type'] === 'success')
                            {
                                document.location.reload()
                            }
                            else
                            {

                                $('.application_options .errors').find('.alert').remove();

                                $('.application_options .errors').append(
                                    $('<div />')
                                        .addClass(['alert', 'alert-warning'])
                                        .text(response['message'])
                                );

                                button.removeAttr('disable');
                                button.find('span.spinner-border')
                                    .addClass('spinner-hide')
                                ;
                            }
                        }
                    );

                    e.preventDefault();
                }
            )
        }
    )