import { getAvatarUrl } from '@/config'

export function getChatonImagePath(id: number): string {
    const n = ((id - 1) % 10) + 1;
    return getAvatarUrl(`chaton_${n}.png`);
  }
  