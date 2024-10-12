import premai, {askAI} from "./premai_setter.js"

async function toMermaid(prompt) {
    const client = premai()

    const messages = []
    messages.push({
        role: "user", 
        content: "Convert the following conceptual map to a mermaid compatible map (THE MINDMAP MUST START WITH 'mindmap\nroot(('): " + prompt
    })

    let response = await askAI(client, messages)
    let result = response.choices[0].message.content
    
    result = result.replaceAll("-", "_TAB_")
    result = result.replaceAll("  ", "_TAB_")
    result = result.replaceAll("\n", "_NL_")
    result = result.replaceAll("`", "")
    result = result.replaceAll("*", "")
    result = result.replaceAll('"', "'")

    return result
}

export default toMermaid