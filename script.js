//Note Script 
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
	document.querySelectorAll(".note textarea").forEach(note => {
		if (note.value == "") {
			note.parentElement.remove()
		} else {
			notes.push(note.value);
		}
		setNotes(notes);
	})
}

function cleanNote() {
	var note = document.activeElement;
	if (note.value == "(new note)") {
	    note.value = "";
	}
}
	
function addNote() {
	document.getElementById("addbutton").remove();
	appendNote("(new note)");
	appendNoteButton();
	collectNotes();
}
function appendNote(text) {
	var note = document.createElement("div");
	note.classList.add("note");
	note.innerHTML = `<textarea>${text}</textarea>`;
	note.addEventListener("focusin", cleanNote);
	note.addEventListener("focusout", collectNotes);
	noteContainer.appendChild(note);
}

function appendNoteButton() {
	var addButton = document.createElement("button");
	addButton.id = "addbutton";
	addButton.innerHTML = '+ Add Note';
	addButton.addEventListener("click", addNote);
	noteContainer.appendChild(addButton);
}

var notes = getNotes();

notes.forEach(n => {appendNote(n)});
appendNoteButton();

document.getElementById("addNoteIcon")?.addEventListener("click", addNote);