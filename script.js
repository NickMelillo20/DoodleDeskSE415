document.addEventListener("DOMContentLoaded", () => {
	const noteContainer = document.querySelector(".note-container");

	function getNotes() {
		if (!localStorage.getItem(NOTES_KEY))
			localStorage.setItem(NOTES_KEY, JSON.stringify([]));
		return JSON.parse(localStorage.getItem(NOTES_KEY));
	}

	function setNotes(notes) {
		localStorage.setItem(NOTES_KEY, JSON.stringify(notes));
	}
	
function collectNotes() {
    var notes = [];

    document.querySelectorAll(".note").forEach(note => {
        const textarea = note.querySelector("textarea");
        const text = textarea.value;

        if (text === "") {
            note.remove();
        } else {
            notes.push({
                text: text,
                x: note.offsetLeft,
                y: note.offsetTop,
				width: note.offsetWidth,
				height: note.offsetHeight
            });
        }
    });

    setNotes(notes);
}

	function cleanNote() {
		var note = document.activeElement;
		if (note.value == "(new note)") {
			note.value = "";
		}
	}
	
function addNote() {
    appendNote({
        text: "(new note)",
        x: 100,
        y: 100
    });
    collectNotes();
}

function appendNote(noteData) {
    var note = document.createElement("div");
    note.classList.add("note");

    const text = noteData.text || noteData; // supports old format
    const x = noteData.x || 50;
    const y = noteData.y || 50;
	const width = noteData.width || 200;
	const height = noteData.height || 150;

    note.innerHTML = `
        <button class="dragBtn">Drag</button>
        <textarea>${text}</textarea>
    `;

    // Apply saved position
    note.style.position = "absolute";
    note.style.left = x + "px";
    note.style.top = y + "px";

	note.style.width = width + "px";
	note.style.height = height + "px";

    const dragBtn = note.querySelector(".dragBtn");

    note.addEventListener("focusin", cleanNote);
    note.addEventListener("focusout", collectNotes);

    enableDrag(note, dragBtn);

    noteContainer.appendChild(note);
}

function enableDrag(note, dragBtn) {
    let isDragging = false;
    let offsetX = 0;
    let offsetY = 0;

    dragBtn.addEventListener("click", () => {
        isDragging = !isDragging;
        dragBtn.textContent = isDragging ? "Stop" : "Drag";
    });

    note.addEventListener("mousedown", (e) => {
        if (!isDragging) return;

        const containerRect = noteContainer.getBoundingClientRect();
        const noteRect = note.getBoundingClientRect();

        // IMPORTANT: convert mouse position into container space
        const mouseX = e.clientX - containerRect.left;
        const mouseY = e.clientY - containerRect.top;

        offsetX = mouseX - note.offsetLeft;
        offsetY = mouseY - note.offsetTop;

        function onMouseMove(e) {
            const containerRect = noteContainer.getBoundingClientRect();

            const mouseX = e.clientX - containerRect.left;
            const mouseY = e.clientY - containerRect.top;

            let newX = mouseX - offsetX;
            let newY = mouseY - offsetY;

            // clamp inside container
            const maxX = containerRect.width - note.offsetWidth;
            const maxY = containerRect.height - note.offsetHeight;

            newX = Math.max(0, Math.min(newX, maxX));
            newY = Math.max(0, Math.min(newY, maxY));

            note.style.left = newX + "px";
            note.style.top = newY + "px";
        }

        function onMouseUp() {
            document.removeEventListener("mousemove", onMouseMove);
            document.removeEventListener("mouseup", onMouseUp);
            collectNotes();
        }

        document.addEventListener("mousemove", onMouseMove);
        document.addEventListener("mouseup", onMouseUp);
    });
}

	var notes = getNotes();
	notes.forEach(n => appendNote(n));

	document.getElementById("noteIcon")?.addEventListener("click", addNote);

});
