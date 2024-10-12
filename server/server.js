import express from "express"
import cors from 'cors'
import bodyParser from "body-parser"
import generateNote from "../server/notes_generator.js"
import toMermaid from "../server/mermaid_converter.js"
import queryDatabase from "../server/connectDatabase.js"

const app = express()
const port = 3000

app.use(cors({
    origin: 'http://localhost'  
}))
app.use(bodyParser.urlencoded({ extended: false }))

// Parse application/json
app.use(bodyParser.json());

app.listen(port, () => {
    console.log(`Server running on port ${port}`)
});

app.post("/generateNotes", async(req, res) => {
    res.setHeader("Content-Type", "text/plain")

    let text = req.body.text
    let type = req.body.noteType
    let accuracy = req.body.accuracy
    let language = req.body.language
    let isPublic = req.body.isPublic
    let subject = req.body.subject
    
    let note = await generateNote(text, type, accuracy, language)
    let response = {
        note: note,
        map : ""
    }
    if(type == "conceptualMap") {
        response.map = await toMermaid(note)
    }
    

    response.isPublic = isPublic
    response.subject = subject
    response.type = type

    console.log(response)

    res.json(response)
})

app.get("/queryDatabase", async(req, res) => {
    res.setHeader("Content-Type", "application/json")
    let sql = req.query.sql
    let result = await queryDatabase(sql)
    res.json(result)
})