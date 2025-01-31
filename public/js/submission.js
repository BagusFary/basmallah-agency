
$("input[name='employment_status']").on("change", checkEmployementStatus);
$("input[name='salary']").on("change", checkIncomeStatus);
$("input[name='has_instalment']").on("change", checkInstalmentStatus);

$("#join_husband, #join_wife_input").on("input", function (event) {
    // console.log(event);
    validatePriceInput(event);
    updateTotalIncome();
});

$('#self_income_input, #avg_monthly_turnover_input, #instalment_amount_input').on("input", function(event){
    // console.log(event);
    validatePriceInput(event);
})

$('#phone').on("input", function(event){
    validatePhoneInput(event);
})

function clearSelfEmployeeInput(){
    $('#self_employee_as').val("");
    $('#avg_monthly_turnover_input').val("");

    $('#self_employee_as').prop("required",false);
    $('#avg_monthly_turnover_input').prop("required",false);
    
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
        $('#avg_monthly_turnover_input').prop("required", true);
    }
}

function clearJointIncomeInput(){
    $("#join_husband").val("");
    $("#join_wife_input").val("");
    $("#total_joint").text("Rp.0");

    $('#join_husband').prop('required',false); 
    $('#join_wife_input').prop('required',false); 
}

function clearSelfIncomeInput(){
    $("#self_income_input").val("");
    $("#total_joint").text("Rp.0");

    $('#self_income_input').prop('required',false); 
}


function checkIncomeStatus(){
    if(!$('#joint_income').is(':checked')){
        $('#join_income_section').addClass('hidden'); 
        $('#self_income_section').removeClass('hidden'); 
        $('#self_income_input').prop('required',true); 
        clearJointIncomeInput();
    } else {
        $('#self_income_section').addClass('hidden'); 
        $('#join_income_section').removeClass('hidden');
        $('#join_husband').prop('required',true); 
        $('#join_wife_input').prop('required',true);  
        clearSelfIncomeInput();
    }
}

function checkInstalmentStatus(){
    if(!$('#instalment_yes').is(':checked')){
        $('#instalment_amount_section').addClass('hidden'); 
        $('#instalment_amount_input').prop('required',false); 
    } else {
        $('#instalment_amount_section').removeClass('hidden');  
        $('#instalment_amount_input').prop('required',true); 
    }
}

function validatePriceInput(event) {
    let input = $(event.target);

    let numericValue = input.val().replace(/\D/g, '');
    
    if (numericValue) {
        input.val("Rp. " + parseInt(numericValue).toLocaleString("id-ID"));
    } else {
        input.val("Rp. 0")
    }

    // $('#' + input.id).val(numericValue).trigger('input');

    // set real input data
    let target = input.id;
    $('#' + target).val(numericValue);
}

function validatePhoneInput(event) {
    let input = event.target;
    input.value = input.value.replace(/\D/g, '');
}

function updateTotalIncome() {
    let husbandIncome = parseInt($("#join_husband").val().replace(/\D/g, "")) || 0;
    let wifeIncome = parseInt($("#join_wife_input").val().replace(/\D/g, "")) || 0;
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

