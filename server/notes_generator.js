import premai, {askAI} from "./premai_setter.js"

async function generateNote(prompt, type, accuracy, language) {
    const client = premai()

    const messages = []
    messages.push({
        role: "user", 
        content: istructions(type, accuracy, language) + prompt
    })
    const response = await askAI(client, messages)
    console.log(response)
    return response.choices[0].message.content
}

function istructions(type, accuracy, language) {
    let tipo, accuratezza
    if(type == "summary"){
        let example = "##The title of the summary##\n@@The title of the paragraph@@\n!!The body of the paragraph!!"
        let rules = "THE SUMMARY MUST BE DIVIDED INTO 2 PARTS : THE TITLE THAT MUST START WITH '##' AND FINISH WITH '##' AND THE PARAGRAPHS. EVERY PARAGRAP IS DIVIDED INTO PARAGRAPH TITLE THAT MUST START WITH '@@' AND FINISH WITH '@@' AND THE PARAGRAPH BODY THAT MUST START WITH '!!' AND FINISH WITH THE SAME CHARACTERS. EVERY SUMMARIES CAN HAVE MORE THAT ONE PARAGRAPH AND EVERY PARAGRAPH HAS TO BE THE SAME FORMAT. DO NOT GIVE COMMENTS AND THAT WILL BE A ONLY STRING FOR ALL THE SUMMARY."
        tipo = "summary of the topic BUT HAVE TO CONTAIN EVERY INFORMATION GIVEN AND EVERY INFORMATION THAT YOU CONSIDER NECESSARY TO UNDERSTAND THE TOPIC. THIS SUMMARY MUST BE GENERATE IN THIS LANGUAGE " + language + " FOLLOWING THIS RULES: '" + rules + "' AND THIS EXAMPLE: '" + example + "'"
    }
    else {
        let example = "EVERY CHILD OF AN AVENT OR A POINT MUST BE SHOWN USING '  ', THE MINDMAP MUST START WITH 'mindmap\n  root(main topic)' WHERE 'main topic' MUST BE REPLACED BY THE ACTUAL TOPIC YOU WERE ASKED; EVERY MINDMAP'S KEY POINT MUST START WITH '-'. DO NOT GIVE COMMENTS."
        tipo = 'mermaid compatible mindmap (YOU MUST GENERATE IT IN THIS LANGUAGE ' + language + ' FOLLOWING THIS EXAMPLE: "' + example
    }   
        
    if(accuracy == "very_detailed") 
        accuratezza = "pretty much detailed"
    else if(accuracy == "detailed")
        accuratezza = "not too many detailed"
    else 
        accuratezza = "short"

    return "Generate a " + accuratezza + " " + tipo + " about this topic: "
}

export default generateNote