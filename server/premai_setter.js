import Prem from "@premai/prem-sdk"
import { configDotenv } from "dotenv"

function premai() {
    configDotenv({path: "./cript/.env"})
    const apikey = process.env.PREMAI_API_KEY

    return new Prem({
        apiKey: apikey
    })
}

const settings = {
    project_id: process.env.PROJECT_ID,
    model: "gpt-3.5-turbo",
    temperature: 0.5,
    frequency_penalty: 0.3,
    presence_penalty: 0.5,
    system_prompt: "You are a helpful assistant that provides notes based on the user's prompt."
}

async function askAI(client, messages) {
    try{
        return await client.chat.completions.create({
            project_id: process.env.PROJECT_ID,
            messages: messages,
            model: settings.model,
            system_prompt: settings.system_prompt
        })
    }catch(Exception) {
        console.error(Exception)
    }
}

export default premai
export {askAI}