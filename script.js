document.addEventListener("DOMContentLoaded", () => {

	const NOTES_KEY = "notes";
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
                y: note.offsetTop
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

    note.innerHTML = `
        <button class="dragBtn">Drag</button>
        <textarea>${text}</textarea>
    `;

    // Apply saved position
    note.style.position = "absolute";
    note.style.left = x + "px";
    note.style.top = y + "px";

    const dragBtn = note.querySelector(".dragBtn");

    note.addEventListener("focusin", cleanNote);
    note.addEventListener("focusout", collectNotes);

    enableDrag(note, dragBtn);

    noteContainer.appendChild(note);
}

function enableDrag(note, dragBtn) {
    let isDragging = false;
    let offsetX, offsetY;

    dragBtn.addEventListener("click", () => {
        isDragging = !isDragging;
        dragBtn.textContent = isDragging ? "Stop" : "Drag";

        if (isDragging) {
            note.style.position = "absolute";
            note.style.zIndex = 1000;
        }
    });

    note.addEventListener("mousedown", (e) => {
        if (!isDragging) return;

        offsetX = e.clientX - note.offsetLeft;
        offsetY = e.clientY - note.offsetTop;

        function onMouseMove(e) {
			const containerRect = noteContainer.getBoundingClientRect();
 			const noteRect = note.getBoundingClientRect();
			let newX = e.clientX - offsetX;
			let newY = e.clientY - offsetY;
	
			// Clamp within container bounds
			const minX = containerRect.left;
			const minY = containerRect.top;
			const maxX = containerRect.right - noteRect.width;
			const maxY = containerRect.bottom - noteRect.height;

    		newX = Math.max(minX, Math.min(newX, maxX));
    		newY = Math.max(minY, Math.min(newY, maxY));

    		// Convert to container-relative position
    		note.style.left = (newX - containerRect.left) + "px";
    		note.style.top = (newY - containerRect.top) + "px";
		}

        document.addEventListener("mousemove", onMouseMove);

        document.addEventListener("mouseup", () => {
            document.removeEventListener("mousemove", onMouseMove);
            collectNotes();
        }, { once: true });
    });
}

	var notes = getNotes();
	notes.forEach(n => appendNote(n));

	document.getElementById("addNoteIcon")?.addEventListener("click", addNote);

});
