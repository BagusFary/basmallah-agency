import "flowbite";
import "../css/app.css";

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
    if ($("#loading-state").length) {
        $("#loading-state").fadeOut(1000).delay(500);
    }
}

function StartUpGSAP() {
    let tl = gsap.timeline({
        delay: 0.5,
        paused: false, // default is false
        repeat: -1, // number of repeats (-1 for infinite)
        repeatDelay: 0, // seconds between repeats
        repeatRefresh: true, // invalidates on each repeat
        yoyo: true, // if true > A-B-B-A, if false > A-B-A-B
        yoyoEase: true,
        defaults: {
            // children inherit these defaults
            duration: 1,
            ease: "power1.inOut",
        },
    });

    let tl2 = gsap.timeline({
        delay: 0.8,
        paused: false, // default is false
        repeat: -1, // number of repeats (-1 for infinite)
        repeatDelay: 0, // seconds between repeats
        repeatRefresh: true, // invalidates on each repeat
        yoyo: true, // if true > A-B-B-A, if false > A-B-A-B
        yoyoEase: true,
        defaults: {
            // children inherit these defaults
            duration: 1,
            ease: "power1.inOut",
        },
    });

    let tl3 = gsap.timeline({
        delay: 1,
        paused: false, // default is false
        repeat: -1, // number of repeats (-1 for infinite)
        repeatDelay: 0, // seconds between repeats
        repeatRefresh: true, // invalidates on each repeat
        yoyo: true, // if true > A-B-B-A, if false > A-B-A-B
        yoyoEase: true,
        defaults: {
            // children inherit these defaults
            duration: 1,
            ease: "power1.inOut",
        },
    });

    tl.to("#souvenir-1", {
        y: 10,
    });

    tl2.to("#souvenir-2", {
        y: 10,
    });

    tl3.to("#souvenir-3", {
        y: 10,
    });

    const highlight = $(".highlight-1");

    gsap.to(".highlight-1", {
        scrollTrigger: {
            trigger: ".highlight-1",
            toggleAction: "restart none reverse none",
        },
        keyframes: [
            // { y: -20, duration: 1, ease: "power4.inOut" },
            { y: -20, opacity: 1, duration: 1, ease: "power4.inOut" },
            {
                scale: 1.5,
                duration: 1,
                padding: "3rem",
                ease: "power4.inOut",
            },
            {
                scale: 1,
                duration: 1,
                padding: "0rem",
                delay: 1,
                ease: "power4.inOut",
            },
            { y: 0, opacity: 0, duration: 1, ease: "power4.inOut" },
        ],
        repeat: -1,
        repeatDelay: 4,
    });

    gsap.to(".highlight-2", {
        scrollTrigger: {
            trigger: ".highlight-2",
            toggleAction: "restart none reverse none",
        },
        keyframes: [
            // { y: -20, duration: 1, ease: "power4.inOut" },
            { y: 40, opacity: 1, duration: 1, ease: "power4.inOut" },
            {
                scale: 1.5,
                duration: 1,
                padding: "3rem",
                ease: "power4.inOut",
            },
            {
                scale: 1,
                duration: 1,
                padding: "0rem",
                delay: 1,
                ease: "power4.inOut",
            },
            { y: 0, opacity: 0, duration: 1, ease: "power4.inOut" },
        ],
        repeat: -1,
        delay: 4,
        repeatDelay: 4,
    });
}

$(document).ready(function () {
    gsap.registerPlugin(ScrollTrigger);
    startLoadingState();

    $("#btn-next-button").click(() => {
        fetchingFAQ();
    });

    // Create a timeline
    StartUpGSAP();
});
