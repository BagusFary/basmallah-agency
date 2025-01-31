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
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    “${faq.ask_question}”</span>
            </div>
            <div class="text-base font-normal text-gray-500 dark:text-gray-400">
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

$(document).ready(function () {
    const btnNextButton = `<button id="btn-next-button" type="button"
                        class="w-full rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">View
                        more questions</button>`;
    $(document).scroll(function () {
        var scroll = $(this).scrollTop();
        var topDist = $("#container").position();
        if (scroll > topDist.top) {
            if ($(".navbar").css("position") === "fixed") return;
            $(".navbar")
                .css({
                    position: "fixed",
                    width: "100%",
                    // opacity: "1",
                    transition: "ease-in-out",
                    display: "none", // Tambahkan opacity untuk fade-in
                })
                .delay(100)
                .slideDown(300);
        } else {
            $(".navbar")
                .css({
                    position: "static",
                    transition: "ease-in-out",
                    display: "none",
                    "box-shadow": "0px 0px 0px lightblue",
                })
                // .delay(100)
                .slideDown(200);
            // $(".navbar").stop();
        }
    });

    $("#btn-next-button").click(() => {
        fetchingFAQ();
    });
});
