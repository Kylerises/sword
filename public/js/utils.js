    // TOAST
    let toastQueue = []

    export function showToast(message, type = "info"){

        if(toastQueue.includes(message)) return
        toastQueue.push(message)

        const container = document.getElementById("toast-container")

        const toast = document.createElement("div")
        toast.classList.add("toast", type)
        toast.textContent = message

        container.appendChild(toast)

        setTimeout(() => {
            toast.remove()
            toastQueue = toastQueue.filter(t => t !== message)
        }, 3000);
    }

    // Function for formatted number into human readable format
    export function formatNumber(number) {

        number = Number(number)

        const suffixes = ['', 'K', 'M', 'B', 'bl', 'Bd', 'tl', 'Td', 'ql', 'Qd', 'qil', 'Qid', 'sl', 'Sd', 'spl', 'Spd', 'ol', 'Od', 'nl', 'Nd', 'dl', 'Dd', 'vl', 'Vd', 'ttl', 'Ttd', 'qdl', 'Qdd'];

        let i = 0;

        while (number >= 1000 && i < suffixes.length - 1) {
            number = number / 1000;
            i++;
        }

        return number.toFixed(2).replace(/\.00$/, '') + suffixes[i];
    }