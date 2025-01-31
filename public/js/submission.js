
$("input[name='employment_status']").on("change", checkEmployementStatus);
$("input[name='salary']").on("change", checkIncomeStatus);
$("input[name='has_instalment']").on("change", checkInstalmentStatus);

$("#join_husband, #join_wife").on("input", function (event) {
    validatePriceInput(event);
    updateTotalIncome();
});

$('#self_income, #avg_monthly_turnover, #instalment_amount').on("input", function(event){
    validatePriceInput(event);
})

$('#phone').on("input", function(event){
    validatePhoneInput(event);
})

function clearSelfEmployeeInput(){
    $('#self_employee_as').val("");
    $('#avg_monthly_turnover').val("");

    $('#self_employee_as').prop("required",false);
    $('#avg_monthly_turnover').prop("required",false);
    
}

function checkEmployementStatus(){
    if(!$('#self_employees').is(':checked')){
        $('#self_employee_as_section').addClass('hidden'); 
        $('#avg_monthly_turnover_section').addClass('hidden'); 
        clearSelfEmployeeInput();
    } else {
        $('#self_employee_as_section').removeClass('hidden'); 
        $('#avg_monthly_turnover_section').removeClass('hidden'); 
        $('#self_employee_as').prop("required", true);
        $('#avg_monthly_turnover').prop("required", true);
    }
}

function clearJointIncomeInput(){
    $("#join_husband").val("");
    $("#join_wife").val("");
    $("#total_joint").text("Rp.0");

    $('#join_husband').prop('required',false); 
    $('#join_wife').prop('required',false); 
}

function clearSelfIncomeInput(){
    $("#self_income").val("");
    $("#total_joint").text("Rp.0");

    $('#self_income').prop('required',false); 
}


function checkIncomeStatus(){
    if(!$('#joint_income').is(':checked')){
        $('#join_income_section').addClass('hidden'); 
        $('#self_income_section').removeClass('hidden'); 
        $('#self_income').prop('required',true); 
        clearJointIncomeInput();
    } else {
        $('#self_income_section').addClass('hidden'); 
        $('#join_income_section').removeClass('hidden');
        $('#join_husband').prop('required',true); 
        $('#join_wife').prop('required',true);  
        clearSelfIncomeInput();
    }
}

function checkInstalmentStatus(){
    if(!$('#instalment_yes').is(':checked')){
        $('#instalment_amount_section').addClass('hidden'); 
        $('#instalment_amount').prop('required',false); 
    } else {
        $('#instalment_amount_section').removeClass('hidden');  
        $('#instalment_amount').prop('required',true); 
    }
}

function validatePriceInput(event) {
    let input = event.target;
    let numericValue = input.value.replace(/\D/g, '');
    if (numericValue) {
        input.value = "Rp." + parseInt(numericValue).toLocaleString("id-ID");
    } else {
        input.value = "Rp.0";
    }

    // set real input data
    let target = input.id + "_data";
    $('#' + target).val(numericValue);
}

function validatePhoneInput(event) {
    let input = event.target;
    input.value = input.value.replace(/\D/g, '');
}

function updateTotalIncome() {
    let husbandIncome = parseInt($("#join_husband").val().replace(/\D/g, "")) || 0;
    let wifeIncome = parseInt($("#join_wife").val().replace(/\D/g, "")) || 0;
    let totalIncome = husbandIncome + wifeIncome;
    $("#total_joint").text("Rp." + totalIncome.toLocaleString("id-ID"));
}

$("#toggle-join-income").on("click", function () {
    $("#join_income_section").slideToggle();
});


$(document).ready(function (){
    checkEmployementStatus();
    checkIncomeStatus();
    checkInstalmentStatus();
});

