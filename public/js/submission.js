let housingPartnerCode = "";
let token = "";
$("input[name='employment_status']").on("change", checkEmployementStatus);
$("input[name='salary']").on("change", checkIncomeStatus);
$("input[name='has_instalment']").on("change", checkInstalmentStatus);

$("#join_husband_input, #join_wife_input").on("input", function (event) {
    validatePriceInput(event);
    updateTotalIncome();
});

$("#id_card").keyup(function (event) {
    let input = $(event.target);
    let valueReplaced = input.val().replace(/\D/g, "");
    input.val(valueReplaced);
});

$(
    "#self_income_input, #avg_monthly_turnover_input, #instalment_amount_input"
).keyup(function (event) {
    validatePriceInput(event);
});

$("#submit-submission").on("click", function (event) {
    event.preventDefault();
    const elementCode = document.createElement("input");
    const elementToken = document.createElement("input");
    elementToken.name = "_token";
    elementToken.value = token;
    elementToken.type = "hidden";
    elementCode.name = "code";
    elementCode.value = housingPartnerCode;
    elementCode.type = "hidden";
    $("#form-submission").append(elementCode);
    $("#form-submission").append(elementToken);
    $("#form-submission").submit();
});

$("#phone").on("input", function (event) {
    validatePhoneInput(event);
});

function clearSelfEmployeeInput() {
    $("#self_employee_as").val("");
    $("#avg_monthly_turnover_input").val("");

    $("#avg_monthly_turnover").val("0");

    $("#self_employee_as").prop("required", false);
    $("#avg_monthly_turnover_input").prop("required", false);
}

function checkEmployementStatus() {
    if (!$("#self_employees").is(":checked")) {
        $("#self_employee_as_section").addClass("hidden");
        $("#avg_monthly_turnover_section").addClass("hidden");
        clearSelfEmployeeInput();
    } else {
        $("#self_employee_as_section").removeClass("hidden");
        $("#avg_monthly_turnover_section").removeClass("hidden");
        $("#self_employee_as").prop("required", true);
        $("#avg_monthly_turnover_input").prop("required", true);
    }
}

function clearJointIncomeInput() {
    $("#join_husband_input").val("");
    $("#join_wife_input").val("");
    $("#total_joint").text("Rp.0");

    $("#join_husband").val("0");
    $("#join_wife").val("0");

    $("#join_husband_input").prop("required", false);
    $("#join_wife_input").prop("required", false);
}

function clearSelfIncomeInput() {
    $("#self_income_input").val("");
    $("#total_joint").text("Rp.0");

    $("#self_income").val("0");

    $("#self_income_input").prop("required", false);
}

function checkIncomeStatus() {
    if (!$("#joint_income").is(":checked")) {
        $("#join_income_section").addClass("hidden");
        $("#self_income_section").removeClass("hidden");
        $("#self_income_input").prop("required", true);
        clearJointIncomeInput();
    } else {
        $("#self_income_section").addClass("hidden");
        $("#join_income_section").removeClass("hidden");
        $("#join_husband_input").prop("required", true);
        $("#join_wife_input").prop("required", true);
        clearSelfIncomeInput();
    }
}

function checkInstalmentStatus() {
    if (!$("#instalment_yes").is(":checked")) {
        $("#instalment_amount_section").addClass("hidden");
        $("#instalment_amount_input").prop("required", false);
    } else {
        $("#instalment_amount_section").removeClass("hidden");
        $("#instalment_amount_input").prop("required", true);
    }
}

function validatePriceInput(event) {
    let input = $(event.target);

    let numericValue = input.val().replace(/\D/g, "");

    if (numericValue) {
        input.val("Rp. " + parseInt(numericValue).toLocaleString("id-ID"));
    } else {
        input.val("Rp. 0");
    }

    // Set data to hidden input
    let inputId = input[0].attributes[3].nodeValue;
    let target = inputId.replace("_input", "");
    $("#" + target).val(numericValue);
}

function validatePhoneInput(event) {
    let input = event.target;
    input.value = input.value.replace(/\D/g, "");
}

function updateTotalIncome() {
    let husbandIncome =
        parseInt($("#join_husband_input").val().replace(/\D/g, "")) || 0;
    let wifeIncome =
        parseInt($("#join_wife_input").val().replace(/\D/g, "")) || 0;
    let totalIncome = husbandIncome + wifeIncome;
    $("#total_joint").text("Rp." + totalIncome.toLocaleString("id-ID"));
}

$("#toggle-join-income").on("click", function () {
    $("#join_income_section").slideToggle();
});

function clipboardClick() {
    const code = $("#code-referral-clipboard").text().replace(" ", "");
    navigator.clipboard.writeText(code);
    // $("#clipboard-success").stop();
    $("#clipboard-success").show();
}

function removeSensitiveField() {
    token = $('input[name="_token"]').val();
    $('input[name="_token"]').remove();
    housingPartnerCode = $("#code").val();
    $("#code").remove();
}

$(document).ready(function () {
    removeSensitiveField();
    checkEmployementStatus();
    checkIncomeStatus();
    checkInstalmentStatus();
    updateTotalIncome();
});

$(".share-button").on("click", async (event) => {
    try {
        const titleName = $("#title-name").text();

        const data = {
            title: "Form Submission | " + titleName,
            text: "Ambil rumah anda di Basmallah Agency!",
            url: $(".share-button").attr("id"),
        };

        await navigator.share(data);

        $(".share-button").text("Sudah Dibagikan");
    } catch (err) {
        $(".share-button").text("Bagikan");
    }
});
