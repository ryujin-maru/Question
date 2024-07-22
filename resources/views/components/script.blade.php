<script>
    {
        const buttons = document.querySelectorAll('.btn');
        function hide(btn) {
            var check = true;
            if(btn.value == '次の問題へ' || btn.value == '採点する') {
                const inputs = document.querySelectorAll("input[type='radio']");
                inputs.forEach(input => {
                    if(!input.checkValidity()) {
                        check = false;
                    }
                });
            }

            if(check){
                buttons.forEach(button => {
                button.disabled = true;
                });
                btn.form.submit();
            }
            // console.log(btn.value);
        }
    }
</script>