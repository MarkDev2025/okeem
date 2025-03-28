export const BACKEND_URL = import.meta.env.VITE_BACKEND_URL || 'http://localhost:8000'
export const API_URL = import.meta.env.VITE_API_URL || `${BACKEND_URL}/api`

export const getAvatarUrl = (filename: string) =>
  `${BACKEND_URL}/storage/avatars/${filename}`

export const getPdfUrl = (filename: string) =>
  `${BACKEND_URL}/storage/pdfs/${filename}`
