import "flowbite";

const loadingContent = `
                            <div
                            class="px-3 py-1 text-xs font-medium leading-none text-center text-blue-800 bg-blue-200 rounded-full animate-pulse dark:bg-blue-900 dark:text-blue-200">
                            Loading...</div>
`;
const fetchingFAQ = () => {
    const btnNextButton = $("#btn-next-button");
    btnNextButton.attr("disabled", "true");
    const idCursor = $(".next-button").attr("id");
    btnNextButton.html(loadingContent);

    $.get(
        { url: "/api/house/list?cursor=" + decodeURI(idCursor) },
        function (response, status) {
            const contentFAQ = $("#content-faq");
            let faqs = "";
            response.data.forEach((faq) => {
                const content = `
        <div class="space-y-4 py-6 md:py-8">
                            <div class="grid gap-4">
                                <span class="text-xl font-semibold text-white dark:text-white">
                                    “${faq.ask_question}”</span>
                            </div>
                            <div class="text-base font-normal text-white dark:text-gray-400">
                                ${faq.answer}
                            </div>
                        </div>
        `;
                faqs += content;
            });
            if (response.next_cursor) {
                $(".next-button").attr("id", response.next_cursor);
                $("#btn-next-button").text("Lihat Banyak");
                btnNextButton.attr({
                    disabled: false,
                });
            } else {
                $(".next-button").attr("id", "");
                const nextButton = $("#btn-next-button");
                nextButton.remove();
            }
            // console.log(faqs)
            contentFAQ.append(faqs);
        }
    );
};

function startLoadingState() {
    $("#loading-state").fadeOut(1000);
    $("#body-content").fadeIn(1000);
}

$(document).ready(function () {
    startLoadingState();

    $("#btn-next-button").click(() => {
        fetchingFAQ();
    });
});
