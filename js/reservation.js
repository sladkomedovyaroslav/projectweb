document.addEventListener(
    'DOMContentLoaded',
    () => {

        const form =
            document.getElementById(
                'reservationForm'
            );

        if (!form) {
            return;
        }

        form.addEventListener(
            'submit',
            async function(e) {

                e.preventDefault();

                const formData =
                    new FormData(form);

                const data = {
                    table_types: []
                };

                formData.forEach(
                    (value, key) => {

                        if (
                            key === 'table_types[]'
                        ) {

                            data.table_types.push(
                                value
                            );

                        } else {

                            data[key] = value;
                        }
                    }
                );

                try {

                    const response =
                        await fetch(
                            '/api/reservations',
                            {
                                method: 'POST',

                                headers: {
                                    'Content-Type':
                                        'application/json'
                                },

                                body:
                                    JSON.stringify(
                                        data
                                    )
                            }
                        );

                    const result =
                        await response.json();

                    if (
                        result.success
                    ) {

                        alert(
                            'Бронь успешно создана\n\n' +
                            'Логин: ' +
                            result.login +
                            '\nПароль: ' +
                            result.password
                        );

                        form.reset();

                    } else {

                        if (
                            result.errors
                        ) {

                            let text =
                                '';

                            for (
                                let key
                                in result.errors
                            ) {

                                text +=
                                    result.errors[key]
                                    +
                                    '\n';
                            }

                            alert(text);

                        } else {

                            alert(
                                result.message
                            );
                        }
                    }

                } catch (e) {

                    alert(
                        'Ошибка соединения'
                    );
                }
            }
        );
    }
);
