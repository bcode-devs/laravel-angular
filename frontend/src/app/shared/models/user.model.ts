export interface User {
  id: string;
  ident: string;
  url: string;
  name: any;
  role?: string;
  status?: string;
  email?: string;
  avatar_url?: string;
  phone?: string;
  created_at?: string;
  online?: boolean;
  lastSeen?: string;
}

export interface AuthResponse {
  user: User;
}
